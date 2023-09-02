import { BaseChat, Chat, Contact, GroupChat } from 'types/chat';

export declare type FetchChatsResponse = APIResponse<Chat[]>;
export declare type SearchChatsResponse = APIResponse<{
    chats: Array<BaseChat & GroupChat>;
    contacts: Contact[];
}>;
export declare type FetchChatResponse = APIResponse<Chat>;
