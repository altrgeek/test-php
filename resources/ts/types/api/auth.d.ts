export declare type Gender = 'male' | 'female' | 'other';
export interface Profile extends APIRecord {
    name: string;
    email: string;
    email_verified_at: Nullable<string>;
    gender: Nullable<Gender>;
    address: Nullable<string>;
    avatar: Nullable<string>;
    dob: Nullable<string>;
    latitude: Nullable<number>;
    longitude: Nullable<number>;
    phone: Nullable<string>;
}

export declare type FetchProfileResponse = APIResponse<Profile>;
