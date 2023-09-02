/* eslint-disable jsx-a11y/anchor-is-valid */
import { useAppSelector } from 'hooks';
import React, { FC } from 'react';
import initials from 'initials';

const Actions: FC = () => {
    return (
        <ul className="nk-chat-head-tools">
            <li>
                <a href="#" className="btn btn-icon btn-trigger text-primary">
                    <em className="icon ni ni-call-fill" />
                </a>
            </li>
            <li>
                <a href="#" className="btn btn-icon btn-trigger text-primary">
                    <em className="icon ni ni-video-fill" />
                </a>
            </li>
            <li className="d-none d-sm-block">
                <div className="dropdown">
                    <a
                        href="#"
                        className="dropdown-toggle btn btn-icon btn-trigger text-primary"
                        data-toggle="dropdown"
                    >
                        <em className="icon ni ni-setting-fill" />
                    </a>
                    <div className="dropdown-menu dropdown-menu-right">
                        <ul className="link-list-opt no-bdr">
                            <li>
                                <a className="dropdown-item" href="#">
                                    <em className="icon ni ni-archive" />
                                    <span>Make as Archive</span>
                                </a>
                            </li>
                            <li>
                                <a className="dropdown-item" href="#">
                                    <em className="icon ni ni-cross-c" />
                                    <span>Remove Conversion</span>
                                </a>
                            </li>
                            <li>
                                <a className="dropdown-item" href="#">
                                    <em className="icon ni ni-setting" />
                                    <span>More Options</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
            <li className="mr-n1 mr-md-n2">
                <a href="#" className="btn btn-icon btn-trigger text-primary chat-profile-toggle">
                    <em className="icon ni ni-alert-circle-fill" />
                </a>
            </li>
        </ul>
    );
};

const Search: FC = () => {
    return (
        <div className="nk-chat-head-search">
            <div className="form-group">
                <div className="form-control-wrap">
                    <div className="form-icon form-icon-left">
                        <em className="icon ni ni-search" />
                    </div>
                    <input
                        type="text"
                        className="form-control form-round"
                        id="chat-search"
                        placeholder="Search in Conversation"
                    />
                </div>
            </div>
        </div>
    );
};

const Header: FC = () => {
    const chat = useAppSelector((state) => state.chat.active.data);
    const status = useAppSelector((state) => state.chat.active.status);

    // 1. Group icon or other participant's avatar
    // 2. Group name or other participant's name
    // 3. Other participant's status

    if (status === 'success' && chat) {
        // If it is an individual chat then use other participant's name as the
        // chat title, and if it's a group chat then we will have the name

        // Other participant (in individual chat)
        const other = chat.participants.find((participant) => participant.id !== user.id);
        const name = (chat.type === 'group' ? chat.name : other?.name) || 'Unlabeled Conversation';
        const icon = chat.type === 'group' ? chat.icon : other?.avatar;

        return (
            <div className="nk-chat-head">
                <ul className="nk-chat-head-info">
                    <li className="nk-chat-body-close">
                        <a href="#" className="btn btn-icon btn-trigger nk-chat-hide ml-n1">
                            <em className="icon ni ni-arrow-left" />
                        </a>
                    </li>
                    <li className="nk-chat-head-user">
                        <div className="user-card">
                            <div className="user-avatar bg-purple">
                                {icon && <img src={icon} alt={name} />}
                                {!icon && <span>{initials(name).toUpperCase()}</span>}
                            </div>
                            <div className="user-info">
                                <div className="lead-text">{name}</div>
                                {chat.type === 'individual' && (
                                    <div className="sub-text">
                                        <span className="d-none d-sm-inline mr-1">Active </span>
                                        35m ago
                                    </div>
                                )}
                            </div>
                        </div>
                    </li>
                </ul>
                <Actions />
                <Search />
            </div>
        );
    }

    return null;
};

export default Header;
