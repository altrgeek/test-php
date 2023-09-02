import React, { FC } from 'react';
import { useAppSelector } from 'hooks';
import moment from 'moment';
import ChatTile from './ChatTile';

const RecentChats: FC = () => {
    const chats = useAppSelector((state) => state.chat.recent.data.rooms);
    const status = useAppSelector((state) => state.chat.recent.status);
    let idx = -1;
    if (status === 'loading')
        return <div className="pt-5 text-center text-muted">Loading chats....</div>;

    return (
        <ul className="chat-list">
            {chats.map(({ last_message, ...chat }) => {
                idx++;
                if (chat.type === 'group')
                    return (
                        <ChatTile
                            id={chat.uid}
                            name={chat.name}
                            index = {idx}
                            icon={chat.icon}
                            key={chat.uid}
                            type="group"
                            message={
                                last_message
                                    ? {
                                          text: last_message.content || '',
                                          status:
                                              last_message.user_id !== user.id
                                                  ? last_message.status
                                                  : null,
                                          type: last_message.type,
                                          time: moment(last_message.created_at).unix(),
                                          deleted: last_message.is_deleted
                                      }
                                    : null
                            }
                        />
                        
                    );

                // If we have an individual chat room then there will be no
                // chat name, in that case we will use the name of second
                // chat participant as chat's name
                // Note that we are sure we will have only two participants!
                const contact = chat.participants.find((participant) => {
                    return participant.id !== user?.id;
                });

                return (
                    <ChatTile
                        id={chat.uid}
                        name={contact?.name || 'Unknown'}
                        icon={contact?.avatar}
                        key={chat.uid}
                        index = {idx}
                        type="individual"
                        message={
                            last_message
                                ? {
                                      text: last_message.content || '',
                                      status: last_message.status,
                                      type: last_message.type,
                                      time: moment(last_message.created_at).unix(),
                                      deleted: last_message.is_deleted
                                  }
                                : null
                        }
                    />
                    
                );
                
            })}
        </ul>
    );
};

export default RecentChats;
