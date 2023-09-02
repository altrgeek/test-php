/* eslint-disable import/no-cycle */
import { createSlice, PayloadAction } from '@reduxjs/toolkit';
import { getRecentChats, loadChat, searchChats } from 'store/thunks';
import { BaseChat, Chat, Contact, GroupChat } from 'types/chat';
import { Message } from 'types/message';
import { chatSorter, scrollMessageAreaToBottom } from 'utils';

declare type SearchResults = { groups: Array<BaseChat & GroupChat>; contacts: Contact[] };
declare type RecentChats = { ids: string[]; rooms: Chat[] };

interface State {
    search: StatefulAPIData<SearchResults> & { searched: boolean };
    recent: StatefulAPIData<RecentChats>;
    active: StatefulAPIData<Nullable<Chat>>;
}

const initialState: State = {
    search: {
        status: 'idle',
        data: {
            contacts: [],
            groups: []
        },
        searched: false
    },
    recent: {
        status: 'idle',
        data: {
            ids: [],
            rooms: []
        }
    },
    active: {
        status: 'idle',
        data: null
    }
};

const chatSlice = createSlice({
    name: 'chat',
    initialState,
    reducers: {
        // Updates last_message of matched recent chat and active chat messages
        addMessage(state, action: PayloadAction<{ chat_id: string; message: APIRecord<Message> }>) {
            // If the chat room in which message was sent is loaded in our
            // recent chats, then update the last message of that chat in the
            // sidebar
            if (state.recent.data.ids.includes(action.payload.chat_id)) {
                state.recent.data.rooms = state.recent.data.rooms.map((room) => {
                    if (room.uid !== action.payload.chat_id) return room;

                    console.log('Updating the last message of a recent chat');
                    return { ...room, last_message: action.payload.message };
                });
                state.recent.data.rooms = state.recent.data.rooms.sort(chatSorter);
            }

            // If the chat room in which message was received is actively
            // visible, then add the message to messaging area as well
            if (state.active.data?.uid === action.payload.chat_id) {
                console.log('Adding new message to the active chat');
                state.active.data.messages.push(action.payload.message);
                scrollMessageAreaToBottom();
            }
        },
        // Updates last_message of matched recent chat and active chat messages
        removeMessage(state, action: PayloadAction<{ chat_id: string; message_id: number }>) {
            // If the chat room in which message was deleted is loaded in our
            // recent chats and the deleted message ID matches with the last
            // message of that recent chat then remove the contents of that
            // last message and mark it as deleted
            if (state.recent.data.ids.includes(action.payload.chat_id))
                state.recent.data.rooms = state.recent.data.rooms.map((room) => {
                    if (
                        room.uid === action.payload.chat_id &&
                        room.last_message?.id === action.payload.message_id
                    ) {
                        console.log('Marking last message as deleted of a recent chat');
                        return {
                            ...room,
                            last_message: { ...room.last_message, content: null, is_deleted: true }
                        };
                    }

                    return room;
                });

            // If the chat room in which message was deleted is actively
            // visible, and a message is found with deleted message's ID then
            // remove its contents and mark the message as deleted
            if (state.active.data?.uid === action.payload.chat_id) {
                state.active.data.messages = state.active.data.messages.map((message) => {
                    if (message.id !== action.payload.message_id) return message;

                    console.log('Marking message as deleted in the active chat');
                    return { ...message, content: null, is_deleted: true };
                });
            }
        },
        // Adds new chat to recent chats (if not already added)
        addChat(state, action: PayloadAction<Chat>) {
            // If the chat room is already added in recent chats then ignore it
            if (state.recent.data.ids.includes(action.payload.uid)) return;

            console.log('Adding new chat room to recent chats');

            // Update both the recent chats data and chat IDs array
            state.recent.data.rooms.push(action.payload);
            state.recent.data.rooms = state.recent.data.rooms.sort(chatSorter);
            state.recent.data.ids.push(action.payload.uid);
        },
        // Removes chat room form recent chats and active chat
        removeChat(state, action: PayloadAction<string>) {
            // If the specified chat is present in recent chats then remove it
            // from recent chats
            if (state.recent.data.ids.includes(action.payload)) {
                console.log('Removing chat from the recent chats');

                state.recent.data.rooms = state.recent.data.rooms.filter(
                    ({ uid }) => uid !== action.payload
                );
                state.recent.data.ids = state.recent.data.ids.filter((id) => id !== action.payload);
            }

            // If the specified chat is actively loaded then remove the active
            // chat
            if (state.active.data?.uid === action.payload) {
                console.log('Hiding active chat as it is removed.');

                state.active = { status: 'idle', data: null };
            }
        },
        // Updates the chat room data in recent chats and active chat
        updateChat(state, action: PayloadAction<Chat>) {
            // If the updated chat is present in recent chats, then update the
            // data in recent chats state as well
            if (state.recent.data.ids.includes(action.payload.uid)) {
                state.recent.data.rooms = state.recent.data.rooms.map((room) => {
                    if (room.uid !== action.payload.uid) return room;

                    console.log('Updating chat room details in recent chats');

                    // TODO: Do not set `last_message` from server in response
                    return { ...room, ...action.payload };
                });
            }

            // If updated chat is actively visible then update it's details
            if (state.active.data?.uid === action.payload.uid) {
                console.log('Updating chat details in the active chat');
                state.active.data = { ...state.active.data, ...action.payload };
            }
        },
        resetSearch(state) {
            state.search = { ...initialState.search };
        }
    },
    extraReducers(builder) {
        // Fetch and load recent chats
        builder.addCase(getRecentChats.pending, (state) => {
            state.recent = { ...initialState.recent, status: 'loading' };
        });
        builder.addCase(getRecentChats.fulfilled, (state, action) => {
            state.recent = {
                status: 'success',
                data: {
                    rooms: action.payload.sort(chatSorter),
                    ids: action.payload.map(({ uid }) => uid)
                },
                error: undefined
            };
        });
        builder.addCase(getRecentChats.rejected, (state, { error }) => {
            state.recent = {
                data: { ...initialState.recent.data },
                status: 'error',
                error: error.message
            };
        });

        // Fetch and load active chat
        builder.addCase(loadChat.pending, (state) => {
            state.active = { data: null, status: 'loading', error: undefined };
        });
        builder.addCase(loadChat.fulfilled, (state, action) => {
            state.active = {
                status: 'success',
                data: action.payload,
                error: undefined
            };
        });
        builder.addCase(loadChat.rejected, (state, { error }) => {
            state.active = {
                data: null,
                status: 'error',
                error: error.message
            };
        });

        // Search groups and contacts
        builder.addCase(searchChats.pending, (state) => {
            state.search = { ...initialState.search, status: 'loading' };
        });
        builder.addCase(searchChats.fulfilled, (state, action) => {
            state.search = {
                data: action.payload,
                status: 'success',
                error: undefined,
                searched: true
            };
        });
        builder.addCase(searchChats.rejected, (state, { error }) => {
            state.search = { ...initialState.search, status: 'error', error: error.message };
        });
    }
});

export const { addMessage, removeMessage, addChat, removeChat, updateChat, resetSearch } =
    chatSlice.actions;

export default chatSlice.reducer;
