import { IMicrophoneAudioTrack, ICameraVideoTrack } from 'agora-rtc-sdk-ng';

export declare type LocalStream = { audio: IMicrophoneAudioTrack; video: ICameraVideoTrack };

export declare type Participant = { id: number; name: string; avatar: Nullable<string> };
export interface Session {
    channel: string;
    title: string;
    token: string;
    guest: Participant;
    link: string;
    emotion: {
        detect: boolean;
        api: string;
    };
}
export declare type AgoraConfig = { app_id: string };

export interface CogniConfig {
    session: Session;
    user: Participant & { email: string };
    agora: AgoraConfig;
    __extra?: {
        initializeEcho?: boolean;
    };
}
