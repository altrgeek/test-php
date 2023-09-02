/* eslint-disable import/no-cycle */
import { createAsyncThunk } from '@reduxjs/toolkit';
import { addMessage, removeMessage } from 'store/slices/chat.slice';
import { Message, MessageType } from 'types/message';

declare type SendMessageProps = { chat_id: string; type: MessageType; content: File | string };
export const sendMessage = createAsyncThunk(
    'chat/send-message',
    async (props: SendMessageProps, { dispatch }) => {
        let data: FormData | { type: MessageType; content: string };
        let headers: Record<string, string> = {};

        if (props.type !== 'text') {
            data = new FormData();
            data.append('type', props.type);
            data.append(props.type, props.content);
            headers = { 'Content-Type': 'multipart/form-data' };
        } else data = { type: props.type, content: props.content as string };

        const response = await sanctum<APIResponse<APIRecord<Message>>>(
            `chat/${props.chat_id}/message`,
            { method: 'post', data, headers }
        );

        console.log(response.data.data);

        dispatch(addMessage({ chat_id: props.chat_id, message: response.data.data }));

        return response.data.data;
    }
);

declare type DeleteMessageProps = { message_id: number; chat_id: string };
export const deleteMessage = createAsyncThunk(
    'chat/delete-message',
    async ({ chat_id, message_id }: DeleteMessageProps, { dispatch }) => {
        const response = await sanctum(`chat/${chat_id}/message/${message_id}`, {
            method: 'delete'
        });

        console.log(response.data);

        dispatch(removeMessage({ chat_id, message_id }));
    }
);
export const markAsReceived = createAsyncThunk('chat/mark-as-received', async () => undefined);
export const markAsSeen = createAsyncThunk('chat/mark-as-seen', async () => undefined);
