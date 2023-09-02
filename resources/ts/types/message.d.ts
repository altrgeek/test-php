export declare type MessageType = 'text' | 'image' | 'audio' | 'video' | 'document';
export declare type MessageStatus = 'sent' | 'delivered' | 'seen';

export declare type Activity = APIRecord<Message | Event>;

export interface Message {
    content: Nullable<string>;
    parent_id: Nullable<number>;
    preview: Nullable<string>;
    type: MessageType;
    is_deleted: boolean;
    status: MessageStatus;
    user_id: number;
    user: User;
}

export interface Event {
    event_context: string;
    content: null;
    type: 'event';
    target_id: Nullable<number>;
}
