/* eslint-disable import/no-extraneous-dependencies */
import EchoLib from 'laravel-echo';
import { AxiosError, AxiosStatic, AxiosRequestConfig, AxiosResponse } from 'axios';
import PusherLib from 'pusher-js';
import MyjQuery from './bootstrap';
import { CogniConfig } from './session';

declare type Sanctum = <D = unknown>(
    url: string,
    config?: AxiosRequestConfig
) => Promise<AxiosResponse<D>>;

declare type Role = 'super_admin' | 'admin' | 'provider' | 'client' | 'user';

declare global {
    interface Window {
        Echo: EchoLib;
        axios: AxiosStatic;
        sanctum: Sanctum;
        Pusher: typeof PusherLib;
        user: User;
        jQuery: typeof MyjQuery;
        $: typeof MyjQuery;
        VITE_PUSHER_APP_KEY: string | null;
        VITE_PUSHER_HOST: string | null;
        VITE_PUSHER_PORT: string | null;
        VITE_PUSHER_SCHEME: string | null;
        VITE_APP_URL: string | null;

        // For sessions pages
        __cogni: CogniConfig;
    }

    const Echo: EchoLib;
    const axios: AxiosStatic;
    const Pusher: typeof PusherLib;
    const sanctum: Sanctum;
    const user: User;

    // General types
    type Nullable<T = unknown> = T | null;
    type Maybe<T = unknown> = Nullable<T>;

    // General resource model types
    type APIRecord<T = unknown> = { id: number; created_at: string; updated_at: string } & T;
    type DeletableApiRecord<T = unknown> = APIRecord<T> & { deleted_at: string };

    // Network related types
    type AsyncState = 'idle' | 'loading' | 'success' | 'error';
    type APIResponse<D = unknown> = { success: true; status: number; data: D };
    type APIError = AxiosError<{
        success: false;
        status: number;
        message: Nullable<string>;
    }>;
    interface User extends APIRecord {
        name: string;
        email: string;
        address: Nullable<string>;
        avatar: Nullable<string>;
        dob: Nullable<string>;
        email_verified_at: Nullable<string>;
        gender: Nullable<string>;
        role: Role;
        phone: Nullable<string>;
        latitude: Nullable<number>;
        longitude: Nullable<number>;
    }

    type StatefulAPIData<T = unknown> = { status: AsyncState; data: T; error?: string };
}

export {};
