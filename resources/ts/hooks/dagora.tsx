import {
    Context,
    FC,
    ReactNode,
    createContext,
    useCallback,
    useContext,
    useEffect,
    useMemo,
    useState
} from 'react';
import AgoraRTC, {
    IAgoraRTCClient,
    IAgoraRTCRemoteUser,
    IMicrophoneAudioTrack,
    ICameraVideoTrack,
    IRemoteVideoTrack
} from 'agora-rtc-sdk-ng';
import { AxiosError, AxiosResponse } from 'axios';
import { setEmotionStatus, setEmotionText } from 'store/slices/meeting.slice';
import { useAppDispatch, useAppSelector } from './store';

export declare type LocalStream = { audio: IMicrophoneAudioTrack; video: ICameraVideoTrack };

interface State {
    client: IAgoraRTCClient;
    remoteUser: IAgoraRTCRemoteUser | null;
    localStream: LocalStream | null;
    muteLocalAudioStream: () => undefined | Promise<void>;
    muteLocalVideoStream: () => undefined | Promise<void>;
    unmuteLocalAudioStream: () => undefined | Promise<void>;
    unmuteLocalVideoStream: () => undefined | Promise<void>;
    leaveSession: () => Promise<void>;
}

// eslint-disable-next-line @typescript-eslint/ban-types
export const AgoraContext = createContext<State | {}>({});

export const AgoraProvider: FC<{ children: ReactNode }> = ({ children }) => {
    // Do not update the the client in any case
    const client = useMemo(() => AgoraRTC.createClient({ mode: 'rtc', codec: 'vp8' }), []);

    const dispatch = useAppDispatch();
    const emotion = useAppSelector((state) => state.meeting.emotion);

    // Store current user's audio/video streams and the remote user's as well
    // Note: We are sure there will be only one guest
    const [remoteUser, setRemoteUser] = useState<IAgoraRTCRemoteUser | null>(null);
    const [localStream, setLocalStream] = useState<LocalStream | null>(null);

    // Play the video stream for for guest user in appropriate DOM element
    // Note: We are sure there will be only one guest
    const playRemoteVideo = (track: IRemoteVideoTrack) => {
        const player = document.getElementById('remoteStreamHolder');

        if (!player) return;
        track.stop();

        track.play(player);
    };

    // When the remote user joins set the user details in state so appropriate
    // UI will be rendered using side-effects.
    // Note: We are sure there will be only one guest
    const handleGuestJoin = async (user: IAgoraRTCRemoteUser) => setRemoteUser(user);

    // Play the remote user's audio/video stream when they start publishing them
    const handleGuestUserPublish = useCallback(
        async (user: IAgoraRTCRemoteUser) => {
            await client.subscribe(user, user.hasVideo ? 'video' : 'audio');

            // If the remote user has video then play then create a container for it
            // and play the stream inside it
            if (user.hasVideo && user.videoTrack) {
                // If we already have a stale video player for the remote user then
                // remove it and create a new one
                // Wait for a while so the holder container is mounted in the DOM
                setTimeout(() => user.videoTrack && playRemoteVideo(user.videoTrack), 500);
            }

            // If user has audio then play the audio
            else if (user.hasAudio && user.audioTrack) {
                user.audioTrack.play();
            }
        },
        [client]
    );

    // Stop receiving audio/video stream from remote user when they unpublish
    // their audio/video stream, because if we do not stop checking it will
    // throw an error
    const handleGuestUserUnpublish = useCallback(
        async (user: IAgoraRTCRemoteUser, mediaType?: 'video' | 'audio') => {
            await client.unsubscribe(user, mediaType);
        },
        [client]
    );

    // Play current user's video stream in appropriate DOM element
    const playLocalVideo = (track: ICameraVideoTrack) => {
        const player = document.getElementById('localStreamHolder');

        if (!player || track.isPlaying) return;

        track.play(player);
    };

    // Unsubscribe from remote user's audio and video streams when they leave
    // the meeting room
    const handleGuestLeave = useCallback(
        async (user: IAgoraRTCRemoteUser) => {
            client.unsubscribe(user);

            if (remoteUser)
                [remoteUser.audioTrack, remoteUser.videoTrack].forEach((track) => track?.stop());

            setRemoteUser(null);
        },
        [client, remoteUser]
    );

    // Create user's stream and start the player
    const joinSession = useCallback(async () => {
        const { agora, session, user } = window.__cogni;

        // Join the specified meeting room on startup
        client.join(agora.app_id, session.channel, session.token, user.id);

        // Create audio, video tracks and save the reference so we can
        // manipulate them, e.g disabling microphone when user clicks on the
        // mute button
        const tracks = await AgoraRTC.createMicrophoneAndCameraTracks();
        setLocalStream({ audio: tracks[0], video: tracks[1] });

        playLocalVideo(tracks[1]);

        // Handle additional remote user join and leaving session with
        // appropriate behavior and response
        client.on('user-joined', handleGuestJoin);
        client.on('user-published', handleGuestUserPublish);
        client.on('user-unpublished', handleGuestUserUnpublish);
        client.on('user-left', handleGuestLeave);
        client.on('connection-state-change', async (state) => {
            if (state !== 'CONNECTED') return;

            // Publish current user's audio and video to the channel so other users
            // can subscribe to it
            await client.publish(tracks);
        });
    }, [client, handleGuestUserPublish, handleGuestLeave, handleGuestUserUnpublish]);

    const leaveSession = useCallback(async () => {
        if (localStream) {
            client.unpublish([localStream.audio, localStream.video]);
            Object.values(localStream).forEach((track) => track.stop());
            Object.values(localStream).forEach((track) => track.close());
            setLocalStream(null);
        }
        client.leave();
    }, [client, localStream]);

    const getGuestEmotion = useCallback(async () => {
        if (emotion.status === 'loading') return;

        const video: Nullable<HTMLVideoElement> = document.querySelector(
            '#remoteStreamHolder video'
        );

        if (!video || !remoteUser?.videoTrack) return;

        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d');

        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        context?.drawImage(video, 0, 0);

        const image: Blob | null = await new Promise((resolve) => {
            canvas.toBlob((blob) => resolve(blob));
        });

        if (!image) return;

        const formData = new FormData();
        formData.append('image', image, 'image.png');

        try {
            dispatch(setEmotionStatus('loading'));
            const response: AxiosResponse<{ emotion: string }> = await axios.post(
                window.__cogni.session.emotion.api,
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            );
            dispatch(setEmotionText(response.data?.emotion || 'Unknown emotion'));
            dispatch(setEmotionStatus('success'));
        } catch (err) {
            const error = err as AxiosError<{ message?: string } | any>;
            const data = error.response?.data;
            const message = (data && data?.message) || 'Error occurred!';
            dispatch(setEmotionStatus('error'));
            dispatch(setEmotionText(message));
        }

        axios
            .post('/api/analysis-test', formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            })
            .then(() => console.log('Saved snapshot'))
            .catch(() => console.log('ERROR occurred while saving snapshot'));
    }, [dispatch, remoteUser, emotion]);

    useEffect(() => {
        if (localStream) return;

        joinSession();
    }, [localStream, joinSession]);

    useEffect(() => {
        // Leave the meeting when component unmounts
        return () => {
            client.leave();
        };
    }, [client]);

    useEffect(() => {
        if (!window.__cogni.session.emotion.detect) return;

        const timer = setInterval(getGuestEmotion, 10000);

        // eslint-disable-next-line consistent-return
        return () => clearInterval(timer);
    }, [getGuestEmotion]);

    // Mute user's microphone (audio)
    const muteLocalAudioStream = useCallback(
        () => localStream?.audio && localStream.audio.setMuted(true),
        [localStream]
    );

    // Disable user's webcam (video)
    const muteLocalVideoStream = useCallback(
        () => localStream?.video && localStream.video.setMuted(true),
        [localStream]
    );

    // Unmute user's microphone (audio)
    const unmuteLocalAudioStream = useCallback(
        () => localStream?.audio && localStream.audio.setMuted(false),
        [localStream]
    );

    // Enable user's webcam (video)
    const unmuteLocalVideoStream = useCallback(
        () => localStream?.video && localStream.video.setMuted(false),
        [localStream]
    );

    const provider = useMemo<State>(
        () => ({
            client,
            remoteUser,
            localStream,
            muteLocalAudioStream,
            muteLocalVideoStream,
            unmuteLocalAudioStream,
            unmuteLocalVideoStream,
            leaveSession
        }),
        [
            client,
            remoteUser,
            localStream,
            muteLocalAudioStream,
            muteLocalVideoStream,
            unmuteLocalAudioStream,
            unmuteLocalVideoStream,
            leaveSession
        ]
    );

    return <AgoraContext.Provider value={provider}>{children}</AgoraContext.Provider>;
};
AgoraProvider.displayName = 'AgoraProvider';

export const useAgora = () => useContext<State>(AgoraContext as Context<State>);
