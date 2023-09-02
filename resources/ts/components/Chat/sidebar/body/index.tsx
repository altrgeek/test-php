import React, { FC, ReactNode } from 'react';
// import FavoritesWrapper from './FavoritesWrapper';
import Search from './Search';

const Body: FC<{ children?: ReactNode }> = ({ children }) => {
    return (
        <div className="nk-chat-aside-body" data-simplebar="init">
            <div className="simplebar-wrapper" style={{ margin: 0 }}>
                <div className="simplebar-height-auto-observer-wrapper">
                    <div className="simplebar-height-auto-observer" />
                </div>

                <div className="simplebar-mask">
                    <div className="simplebar-offset" style={{ right: 0, bottom: 0 }}>
                        <div
                            className="simplebar-content-wrapper"
                            style={{ height: '100%', overflow: 'hidden scroll' }}
                        >
                            <div className="simplebar-content" style={{ padding: 0 }}>
                                <Search />
                                {/* <FavoritesWrapper /> */}
                                {/* <ChatsWrapper /> */}
                                {children}
                            </div>
                        </div>
                    </div>
                </div>

                <div className="simplebar-placeholder" style={{ width: 'auto', height: '664px' }} />
            </div>

            <div className="simplebar-track simplebar-horizontal" style={{ visibility: 'hidden' }}>
                <div className="simplebar-scrollbar" style={{ width: 0, display: 'none' }} />
            </div>
            <div className="simplebar-track simplebar-vertical" style={{ visibility: 'visible' }}>
                <div
                    className="simplebar-scrollbar"
                    style={{
                        height: '130px',
                        transform: 'translate3d(0px, 0px, 0px)',
                        display: 'block'
                    }}
                />
            </div>
        </div>
    );
};

export default Body;
