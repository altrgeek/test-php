import { FC } from 'react';

const ProfileDropdown: FC = () => {
    return (
        <div className="dropdown">
            <span className="dropdown-toggle dropdown-indicator" data-toggle="dropdown">
                <div className="user-avatar">
                    {user?.avatar && <img src={user.avatar} alt={user.name} />}
                </div>
                <div className="title">Chats</div>
            </span>
        </div>
    );
};

export default ProfileDropdown;
