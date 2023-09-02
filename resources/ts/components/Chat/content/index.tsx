import { useAppSelector } from 'hooks';
import React, { FC, useMemo } from 'react';
import { groupMessages } from 'utils';
import moment from 'moment';
import ChatBlock from './chat/ChatBlock';
import Message from './chat/Message';
import MessageBlock from './chat/MessageBlock';
import Body from './Body';

const Content: FC = () => {
    const chat = useAppSelector((state) => state.chat.active.data);
    const status = useAppSelector((state) => state.chat.active.status);

    const messages = useMemo(() => groupMessages(chat?.messages || []), [chat]);

    return (
        <Body>
            {status === 'success' &&
                chat &&
                Object.entries(messages).map(([key, group]) => {
                    return (
                        <ChatBlock label={moment(key).format('Do MMM, YYYY')} key={key}>
                            {group.map((message) => {
                                if (message.type === 'event') return null;

                                return (
                                    <MessageBlock
                                        name={message.user.name}
                                        avatar={message.user.avatar}
                                        received={message.user.id !== user.id}
                                        key={message.id}
                                        time={moment(message.created_at).format('h:mm A')}
                                    >
                                        <Message
                                            id={message.id}
                                            chat={chat.uid}
                                            type={message.type}
                                            received={message.user_id !== user.id}
                                            content={
                                                message.is_deleted ? '' : message.content || ''
                                            }
                                            deleted={message.is_deleted}
                                        />
                                    </MessageBlock>
                                );
                            })}
                        </ChatBlock>
                    );
                })}
        </Body>
    );
};

export default Content;
