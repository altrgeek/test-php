import React, { FC } from 'react';
import classnames from 'classnames';

interface Props {
    icon?: string;
    bg?: string;
    name: string;
}

const FavoriteItem: FC<Props> = ({ icon, name, bg }) => {
    return (
        <li>
            <a href="#">
                <div className={classnames('user-avatar', { [`bg-${bg}`]: bg })}>
                    {icon ? <img src={icon} alt={name} /> : <span>AB</span>}
                    <span className="status dot dot-lg dot-success"></span>
                </div>
            </a>
        </li>
    );
};

export default FavoriteItem;
