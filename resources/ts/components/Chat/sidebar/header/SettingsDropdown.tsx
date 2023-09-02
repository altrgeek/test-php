/* eslint-disable jsx-a11y/anchor-is-valid */
import React, { FC, ReactNode } from 'react';

const SettingsDropdown: FC<{ children?: ReactNode }> = ({ children }) => {
    return (
        <div className="dropdown-menu dropdown-menu-right">
            <ul className="link-list-opt no-bdr">
                <li>
                    <a href="#">
                        <span>Settings</span>
                    </a>
                </li>
                <li className="divider" />
                <li>
                    <a href="#">
                        <span>Message Requests</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span>Archives Chats</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span>Unread Chats</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span>Group Chats</span>
                    </a>
                </li>
                {children}
            </ul>
        </div>
    );
};

export default SettingsDropdown;
