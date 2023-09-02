import { FC, useEffect } from 'react';
import Sidebar from 'components/Chat/sidebar';
import Content from 'components/Chat/content';
import { useAppDispatch, useAppSelector } from 'hooks';
import { Message } from 'types/message';
import { addMessage, removeMessage } from 'store/slices/chat.slice';

declare type MessageCreateEventPayload = { chat_id: string; message: APIRecord<Message> };
declare type MessageDeletedEventPayload = { message_id: number; chat_id: string };
const Chat: FC = () => {
    const dispatch = useAppDispatch();
    const chats = useAppSelector((state) => state.chat.recent.data.ids);

    
    useEffect(() => {
        chats.forEach((chat_id) => {
            const channel = `chats.${chat_id}`;

            console.log(channel);

            Echo.private(channel)
                .listen('.message.created', (event: MessageCreateEventPayload) => {
                    console.log('Received event of new message creation');
                    console.log(event);
                    dispatch(addMessage({ chat_id: event.chat_id, message: event.message }));
                })
                .listen('.message.deleted', (event: MessageDeletedEventPayload) => {
                    console.log('Received event of a message deletion');
                    console.log(event);
                    dispatch(removeMessage(event));
                })
                .listen('.group.updated', (event: unknown) => {
                    console.log('Received event of group details updation');
                    console.log(event);
                });
        });

        return () => {
            chats.forEach((chat_id) => Echo.leave(`chat.${chat_id}`));
        };
    }, [dispatch, chats]);

    return (
        <div className="nk-chat">
            
            <Sidebar />
            <Content />
        </div>
    );
};

export default Chat;
