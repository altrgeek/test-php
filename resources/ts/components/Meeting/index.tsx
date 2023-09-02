/* eslint-disable react/style-prop-object */
import AgoraRTC, {
    IAgoraRTCRemoteUser,
    ILocalAudioTrack,
    ILocalVideoTrack,
    IRemoteAudioTrack,
    IRemoteVideoTrack
} from 'agora-rtc-sdk-ng';
import React, { FC, useCallback, useEffect, useMemo, useRef, useState } from 'react';
import { AxiosError, AxiosResponse } from 'axios';
import { Tooltip } from 'flowbite-react';
import moment from 'moment';
import classnames from 'classnames';
import InfoModal from './InfoModal';
import InfoControls from './InfoControls';
import SharingModal from './SharingModal';

const Meeting: FC = () => {
    const engine = useMemo(() => AgoraRTC.createClient({ mode: 'rtc', codec: 'vp8' }), []);

    const {
        agora: { app_id },
        session: { channel, token },
        user: { id: uid }
    } = window.__cogni;

    const [localAudioTrack, setLocalAudioTrack] = useState<ILocalAudioTrack | null>(null);
    const [localVideoTrack, setLocalVideoTrack] = useState<ILocalVideoTrack | null>(null);
    const [remoteAudioTrack, setRemoteAudioTrack] = useState<IRemoteAudioTrack | null>(null);
    const [remoteVideoTrack, setRemoteVideoTrack] = useState<IRemoteVideoTrack | null>(null);
    const [remoteUid, setRemoteUid] = useState<string | null>(null);

    const [audioMuted, setAudioMuted] = useState<boolean>(false);
    const [videoMuted, setVideoMuted] = useState<boolean>(false);

    const localContainer = useRef<HTMLDivElement>(null);
    const remoteContainer = useRef<HTMLDivElement>(null);

    // Handle guest user channel joining logic
    const handleUserJoin = (user: IAgoraRTCRemoteUser) => {
        console.log(`[handleUserJoin]: User (${user.uid}) joined the channel!`);
        remoteContainer.current!.innerHTML = '';
        setRemoteUid(user.uid.toString());
    };

    // Handle guest user media publishing logic
    const handleUserPublished = useCallback(
        async (user: IAgoraRTCRemoteUser, mediaType: 'video' | 'audio') => {
            await engine.subscribe(user, mediaType);
            console.log(`[handleUserPublished]: Subscribed to remote user (${user.uid})!`);

            if (mediaType === 'video') {
                setRemoteVideoTrack((track) => user.videoTrack || track);
                setRemoteAudioTrack((track) => user.audioTrack || track);
                if (remoteContainer.current) {
                    remoteContainer.current.innerHTML = '';
                    user.videoTrack!.play(remoteContainer.current);
                }
            }

            if (mediaType === 'audio') {
                setRemoteAudioTrack((track) => user.audioTrack || track);
                user.audioTrack!.play();
            }
        },
        [engine]
    );

    // Handle guest user media unpublishing logic
    const handleUserUnpublished = useCallback(
        (user: IAgoraRTCRemoteUser, mediaType: 'video' | 'audio') => {
            console.log(`[handleUserUnpublished]: User (${user.uid}) unpublished streams!`);
            mediaType === 'video' && remoteVideoTrack?.stop();
            mediaType === 'audio' && remoteAudioTrack?.stop();
            engine.unsubscribe(user, mediaType);
        },
        [remoteVideoTrack, remoteAudioTrack, engine]
    );

    // Handle guest user channel leaving logic
    const handleUserLeave = (user: IAgoraRTCRemoteUser) => {
        console.log(`[handleUserLeave]: User (${user.uid}) left the channel!`);
        remoteContainer.current!.innerHTML = '';
        setRemoteUid(null);
        setRemoteVideoTrack(null);
        setRemoteAudioTrack(null);
    };

    // Register engine's event handlers
    useEffect(() => {
        engine.on('user-joined', handleUserJoin);
        engine.on('user-published', handleUserPublished);
        engine.on('user-unpublished', handleUserUnpublished);
        engine.on('user-left', handleUserLeave);
    }, [engine, handleUserPublished, handleUserUnpublished]);

    // Handle channel joining logic
    const handleJoining = useCallback(async () => {
        await engine.join(app_id, channel, token, uid);
        const audioTrack = await AgoraRTC.createMicrophoneAudioTrack();
        const videoTrack = await AgoraRTC.createCameraVideoTrack();

        setLocalAudioTrack(() => audioTrack);
        setLocalVideoTrack(() => videoTrack);

        await engine.publish([audioTrack, videoTrack]);
        localContainer.current && videoTrack.play(localContainer.current);
    }, [engine, app_id, channel, token, uid]);

    useEffect(() => {
        handleJoining();
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, []);

    const [time, setTime] = useState<string>(moment().format('h:mm A'));
    useEffect(() => {
        const interval = setInterval(() => {
            setTime(moment().format('h:mm A'));
        }, 1000);

        return () => clearInterval(interval);
    }, []);

    const [infoOpened, setInfoOpened] = useState(false);
    const [sharingModalOpened, setSharingModalOpened] = useState(true);

    const [emotionStatus, setEmotionStatus] = useState<AsyncState>('idle');
    const [emotionText, setEmotionText] = useState<string | null>(null);

    const getGuestEmotion = useCallback(async () => {
        if (emotionStatus === 'loading') return;

        const video: Nullable<HTMLVideoElement> = document.querySelector(
            '#remoteStreamHolder video'
        );

        if (!video || !remoteVideoTrack) return;

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
            setEmotionStatus('loading');
            const response: AxiosResponse<{ emotion: string }> = await axios.post(
                window.__cogni.session.emotion.api,
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            );
            setEmotionText(response.data?.emotion || 'Unknown emotion');
            setEmotionStatus('success');
        } catch (err) {
            const error = err as AxiosError<{ message?: string } | any>;
            const data = error.response?.data;
            const message = (data && data?.message) || 'Error occurred!';
            setEmotionStatus('error');
            setEmotionText(message);
        }

        // Send captured screenshot to server (for archive in dev mode)
        // axios
        //     .post('/api/analysis-test', formData, {
        //         headers: { 'Content-Type': 'multipart/form-data' }
        //     })
        //     .then(() => console.log('Saved snapshot'))
        //     .catch(() => console.log('ERROR occurred while saving snapshot'));
    }, [emotionStatus, remoteVideoTrack]);

    useEffect(() => {
        if (!window.__cogni.session.emotion.detect) return;

        const timer = setInterval(getGuestEmotion, 1000);

        // eslint-disable-next-line consistent-return
        return () => clearInterval(timer);
    }, [getGuestEmotion]);

    const showEmotionDialog = useMemo(() => {
        // No emotion detection required for this user
        if (!window.__cogni.session.emotion.detect) return false;

        // Emotion detection not started yet
        if (emotionStatus === 'idle') return false;

        // Initial request sent, waiting for response
        if (emotionStatus === 'loading' && !emotionText) return false;

        return true;
    }, [emotionStatus, emotionText]);

    return (
        <div className="flex flex-col items-center w-screen h-screen p-2.5 md:p-5 overflow-x-hidden overflow-y-auto text-white bg-[#202124] relative">
            {/* Preview */}
            <div className="relative flex items-center justify-center flex-1 w-full rounded-lg">
                <SharingModal opened={sharingModalOpened} setOpened={setSharingModalOpened} />
                {/* Remote video holder */}
                <div
                    className={classnames(
                        'max-w-[1000px] w-full h-full rounded-lg relative select-none overflow-hidden bg-gray-800',
                        { 'flex flex-col': remoteUid, hidden: !remoteUid }
                    )}
                >
                    {!remoteVideoTrack && (
                        <div className="absolute inset-0 flex flex-col items-center justify-center space-y-8">
                            <img
                                src={window.__cogni.session.guest.avatar || '/images/user.png'}
                                className="absolute w-40 h-40 transform -translate-x-1/2 -translate-y-1/2 rounded-full top-1/2 left-1/2"
                                alt={window.__cogni.session.guest.name}
                            />
                        </div>
                    )}
                    <span className="absolute z-10 font-bold select-none bottom-5 left-5">
                        {window.__cogni.session.guest.name}
                    </span>

                    <div
                        className="flex-1 w-full h-full"
                        style={{ transform: 'rotateY(180deg)' }}
                        id="remoteStreamHolder"
                        ref={remoteContainer}
                    />

                    {/* Emotion Detection */}
                    {showEmotionDialog && (
                        <div className="px-5 py-2 absolute top-2.5 md:top-[unset] md:bottom-2.5 left-1/2 transform -translate-x-1/2 rounded z-10 bg-black bg-opacity-60 font-medium capitalize max-w-max text-sm md:text-base">
                            {emotionText}
                        </div>
                    )}
                </div>

                {/* Local video holder */}
                <div
                    className={classnames({
                        'flex flex-col justify-center items-center rounded-lg select-none overflow-hidden transition-all':
                            true,
                        'max-w-[1000px] w-full h-full': !remoteUid,
                        'h-36 w-24 right-4 bottom-4 md:h-40 md:w-72 absolute md:bottom-10 md:right-10 bg-gray-800':
                            remoteUid
                    })}
                >
                    <div
                        className="relative flex flex-col items-center justify-center flex-1 w-full h-full"
                        id="localStreamHolder"
                    >
                        {(!localVideoTrack || videoMuted) && (
                            <div className="absolute inset-0 z-10 flex flex-col items-center justify-center space-y-8">
                                <img
                                    src={window.__cogni.user.avatar || '/images/user.png'}
                                    className={classnames('rounded-full', {
                                        'w-36 h-36 md:w-40 md:h-40': !remoteUid,
                                        'w-14 h-14 md:w-20 md:h-20': remoteUid
                                    })}
                                    alt={window.__cogni.user.name}
                                />
                            </div>
                        )}

                        {localVideoTrack && audioMuted && (
                            <div className="absolute inset-0 z-10 flex flex-col items-center justify-center bg-black bg-opacity-10">
                                <i className="text-xl text-white fal fa-microphone-slash" />
                            </div>
                        )}
                        <div className="flex-1 w-full h-full" ref={localContainer} />
                    </div>
                </div>
            </div>
            <InfoModal opened={infoOpened} setOpened={setInfoOpened} guestJoined={!!remoteUid} />
            {/* Footer (time, controls, triggers) */}
            <div className="relative flex items-center justify-between w-full px-2.5 mt-2.5 md:mt-5">
                {/* Current time */}
                <div className="block sm:hidden" />
                <div className="hidden items-center sm:flex">
                    <span className="font-bold">{time}</span>
                </div>

                {/* Meeting controls */}
                <div className="absolute flex items-center px-10 space-x-3 transform -translate-x-1/2 -translate-y-1/2 select-none top-1/2 left-1/2">
                    {/* Video toggle button */}
                    <Tooltip
                        content={videoMuted ? 'Enable camera' : 'Disable camera'}
                        style="light"
                        arrow={false}
                    >
                        <button
                            type="button"
                            className={classnames(
                                'flex items-center justify-center w-10 h-10 rounded-full relative',
                                {
                                    'bg-white text-black': !videoMuted,
                                    'bg-[#EA4335] text-white': videoMuted
                                }
                            )}
                            onClick={(event) => {
                                event.preventDefault();
                                setVideoMuted((muted) => {
                                    localVideoTrack?.setMuted(!muted);
                                    return !muted;
                                });
                            }}
                            disabled={!localVideoTrack}
                        >
                            {!localVideoTrack && (
                                <span className="absolute top-0 right-0 flex items-center justify-center w-5 h-5 text-black transform translate-x-1 -translate-y-1 bg-yellow-300 rounded-full text-xxs">
                                    <i className="fas fa-exclamation" aria-hidden="true" />
                                </span>
                            )}
                            <i className="far fa-video-slash" aria-label="Toggle video" />
                        </button>
                    </Tooltip>

                    {/* Audio toggle button */}
                    <Tooltip
                        content={audioMuted ? 'Enable microphone' : 'Disable microphone'}
                        style="light"
                        arrow={false}
                    >
                        <button
                            type="button"
                            className={classnames(
                                'flex items-center justify-center w-10 h-10 rounded-full relative',
                                {
                                    'bg-white text-black': !audioMuted,
                                    'bg-[#EA4335] text-white': audioMuted
                                }
                            )}
                            disabled={!localAudioTrack}
                            onClick={(event) => {
                                event.preventDefault();
                                setAudioMuted((muted) => {
                                    localAudioTrack?.setMuted(!muted);
                                    return !muted;
                                });
                            }}
                        >
                            {!localVideoTrack && (
                                <span className="absolute top-0 right-0 flex items-center justify-center w-5 h-5 text-black transform translate-x-1 -translate-y-1 bg-yellow-300 rounded-full text-xxs">
                                    <i className="fas fa-exclamation" aria-hidden="true" />
                                </span>
                            )}
                            <i className="far fa-microphone-slash" />
                        </button>
                    </Tooltip>

                    {/* Leave button */}
                    <Tooltip content="Leave call" style="light" arrow={false}>
                        <button
                            type="button"
                            className="flex items-center justify-center w-16 h-10 bg-[#EA4335] rounded-full"
                            onClick={(event) => {
                                event.preventDefault();
                                localVideoTrack && engine.unpublish(localVideoTrack);
                                localAudioTrack && engine.unpublish(localAudioTrack);
                                engine.leave();
                                window.location.href = '/';
                            }}
                        >
                            <i
                                className="fas fa-phone"
                                style={{ transform: 'rotate(-135deg)' }}
                                aria-label="Toggle video"
                            />
                        </button>
                    </Tooltip>
                </div>

                {/* Info togglers */}
                <InfoControls setOpened={setInfoOpened} guestJoined={!!remoteUid} />
            </div>
        </div>
    );
};

export default Meeting;
