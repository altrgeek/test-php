import React, { FC } from 'react';
import { useSelector } from 'react-redux';
import { RootState } from 'types/store';
import RecentChats from './chats/RecentChats';
import SearchedChats from './chats/SearchedChats';

const ChatsWrapper: FC = () => {
    const text = useSelector((state: RootState) => state.chat.search.text);

    return (
        <div className="nk-chat-list">
            <h6 className="title overline-title-alt">Messages</h6>
            {text ? <SearchedChats /> : <RecentChats />}
        </div>
    );
};

export default ChatsWrapper;
