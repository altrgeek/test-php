/* eslint-disable jsx-a11y/anchor-is-valid */
import CreateGroupModal from 'components/Chat/Modal/CreateGroupModal';
import { useAppDispatch, useAppSelector } from 'hooks';
import React, { FC, useEffect } from 'react';
import { getRecentChats } from 'store/thunks';
import { showModal } from 'utils';
import Body from './body';
import RecentChats from './body/chats/RecentChats';
import SearchedChats from './body/chats/SearchedChats';

const Sidebar: FC = () => {
    const dispatch = useAppDispatch();
    const searched = useAppSelector((state) => state.chat.search.searched);

    const allowedRoles: User['role'][] = ['super_admin', 'admin', 'provider'];

    const createGroupModalID = 'createChatGroupModal';

    useEffect(() => {
        dispatch(getRecentChats());
    }, [dispatch]);

    return (
        <div className="nk-chat-aside">
            <CreateGroupModal id={createGroupModalID} />

            {/* Chat header (user profile) */}

            <div className="nk-chat-aside-head">
                <div className="nk-chat-aside-user">
                    <div className="dropdown">
                        <span className="dropdown-toggle dropdown-indicator" data-toggle="dropdown">
                            <div className="user-avatar">
                                {user?.avatar && <img src={user.avatar} alt={user.name} />}
                            </div>
                            <div className="title">Chats</div>
                        </span>
                        {allowedRoles.includes(user.role) && (
                            <div className="dropdown-menu">
                                <ul className="link-list-opt no-bdr">
                                    <li>
                                        <a href="#" onClick={showModal(createGroupModalID)}>
                                            Create Group
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        )}
                    </div>
                </div>
            </div>

            {/* Body (chat tiles) */}
            <Body>
                <div className="nk-chat-list">
                    <h6 className="title overline-title-alt">Messages</h6>
                    {searched ? <SearchedChats /> : <RecentChats />}
                </div>
            </Body>
        </div>
    );
};

export default Sidebar;
