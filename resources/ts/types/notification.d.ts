/* eslint-disable @typescript-eslint/ban-types */

export declare type BroadCastedNotification<D extends Record<string, any> = {}> = {
    id: string;
    type: string;
    title: Nullable<string>;
    description: Nullable<string>;
    icon: Nullable<string>;
    url: Nullable<string>;
} & D;

export interface DatabaseNotification<D extends Record<string, any> = {}> {
    id: string;
    type: string;
    notifiable_type: string;
    notifiable_id: number;
    data: {
        title: Nullable<string>;
        description: Nullable<string>;
        icon: Nullable<string>;
        url: Nullable<string>;
    } & D;
    read_at: Nullable<string>;
    created_at: string;
    updated_at: string;
}

export interface Notification {
    title: string;
    description: Nullable<string>;
    icon: Nullable<string>;
    url: Nullable<string>;
    time: number;
}
