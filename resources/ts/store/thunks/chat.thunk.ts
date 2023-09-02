import { createAsyncThunk } from '@reduxjs/toolkit';
import { BaseChat, Chat, Contact, GroupChat } from 'types/chat';

// Loads all the chats user is a participant of (both group and individual)
export const getRecentChats = createAsyncThunk('chat/recent-chat', async () => {
    const response = await sanctum<APIResponse<Chat[]>>('chat');

    console.log(response.data);
    return response.data.data;
});
// Loads the specified type of chat with few recent messages
declare type Entity = { id: string | number; type: 'contact' | 'group' | 'individual' };
export const loadChat = createAsyncThunk('chat/load-chat', async (entity: Entity) => {
    const response = await sanctum<APIResponse<Chat>>(`chat/${entity.id}?type=${entity.type}`);
    console.log(response.data);

    return response.data.data;
});

// Searches for chat groups and contacts with specified search query
declare type SearchResponse = APIResponse<{
    groups: Array<BaseChat & GroupChat>;
    contacts: Contact[];
}>;
export const searchChats = createAsyncThunk('chat/search-chats', async (query: string) => {
    const response = await sanctum<SearchResponse>('chat/search', { params: { query } });

    console.log(response.data);
    return response.data.data;
});

export const muteChat = createAsyncThunk('chat/mute-chat', async () => undefined);
export const unmuteChat = createAsyncThunk('chat/unmute-chat', async () => undefined);
