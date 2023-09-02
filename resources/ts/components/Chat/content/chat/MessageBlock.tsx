import React, { FC, ReactNode } from 'react';
import classnames from 'classnames';
import initials from 'initials';

interface Props {
    name: string;
    time: string;
    avatar: Nullable<string>;
    received?: boolean;
    children?: ReactNode;
}

interface AvatarProps {
    avatar: Nullable<string>;
    name: string;
}
const UserAvatar: FC<AvatarProps> = ({ avatar, name }) => {
    return (
        <div className="chat-avatar">
            <div className="user-avatar bg-purple">
                {avatar && <img src={avatar} alt={name} />}
                {!avatar && <span>{initials(name).toUpperCase()}</span>}
            </div>
        </div>
    );
};

const MessageBlock: FC<Props> = ({ avatar, received, name, time, children }) => {
    return (
        <div className={classnames('chat is-you', { 'is-you': received, 'is-me': !received })}>
            {received && <UserAvatar {...{ name, avatar }} />}
            <div className="chat-content">
                <div className="chat-bubbles">{children}</div>
                {(name || time) && (
                    <ul className="chat-meta">
                        {name && <li>{name}</li>}
                        {time && <li>{time}</li>}
                    </ul>
                )}
            </div>
        </div>
    );
};

export default MessageBlock;
