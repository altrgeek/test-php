import { Activity, Message } from './message';

export declare type Chat = BaseChat & (GroupChat | IndividualChat);
export declare type Role = 'member' | 'admin' | 'owner';
export declare type Visibility = 'muted' | 'archived' | 'blocked' | 'removed';

export interface BaseChat extends DeletableApiRecord {
    uid: string;
    pivot: {
        user_id: number;
        chat_id: number;
        role: Role;
        visibility: Nullable<Visibility>;
    };
    participants: ChatParticipant[];
    messages: Activity[];
    last_message: Nullable<APIRecord<Message>>;
}

export interface GroupChat {
    type: 'group';
    icon: string;
    name: string;
    description: string;
}

export interface IndividualChat {
    icon: null;
    name: null;
    description: null;
    type: 'individual';
}

export interface ChatParticipant {
    id: number;
    name: string;
    avatar: Nullable<string>;
}

export interface Contact {
    id: number;
    name: string;
    avatar: Nullable<string>;
}
