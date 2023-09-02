import React, { FC, ReactNode } from 'react';

const Header: FC<{ children?: ReactNode }> = () => {
    return (
        <div className="nk-chat-aside-head">
            <div className="nk-chat-aside-user">
                <div className="dropdown">
                    <span className="dropdown-toggle dropdown-indicator" data-toggle="dropdown">
                        <div className="user-avatar">
                            {user?.avatar && <img src={user.avatar} alt={user.name} />}
                        </div>
                        <div className="title">Chats</div>
                    </span>
                </div>
            </div>
        </div>
    );
};

export default Header;
