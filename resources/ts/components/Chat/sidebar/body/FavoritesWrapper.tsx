import React, { FC, ReactNode } from 'react';
import FavoriteItem from './FavoriteItem';

const FavoritesWrapper: FC<{ children: ReactNode }> = ({ children }) => {
    interface Favorite {
        icon?: string;
        name: string;
        bg?: string;
    }

    const data: Favorite[] = [
        { icon: '/images/avatar/b-sm.jpg', name: 'GP' },
        { name: 'AB' },
        { name: 'KH', bg: 'pink' },
        { name: 'VB', bg: 'purple' },
        { icon: '/images/avatar/a-sm.jpg', name: 'LH' },
        { icon: '/images/avatar/c-sm.jpg', name: 'BD' },
        { icon: '/images/avatar/d-sm.jpg', name: 'ZP' },
        { name: 'SK', bg: 'info' }
    ];

    return (
        <div className="nk-chat-aside-panel nk-chat-fav">
            <h6 className="title overline-title-alt">Favorites</h6>
            <ul className="fav-list">
                <li>
                    <a
                        href="#"
                        className="btn btn-lg btn-icon btn-outline-light btn-white btn-round"
                    >
                        <em className="icon ni ni-plus"></em>
                    </a>
                </li>
                {data.map((item, index) => {
                    return <FavoriteItem {...item} key={index} />;
                })}
                {children}
            </ul>
        </div>
    );
};

export default FavoritesWrapper;
