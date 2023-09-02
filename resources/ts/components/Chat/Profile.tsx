import React, { FC } from 'react';

const Profile: FC = () => {
    return (
        <div className="nk-chat-profile" data-simplebar="init">
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
                            <div className="simplebar-content" style={{ padding: 0 }} />
                        </div>
                    </div>
                </div>
                <div className="user-card user-card-s2 my-4">
                    <div className="user-avatar md bg-purple">
                        <span>IH</span>
                    </div>
                    <div className="user-info">
                        <h5>Iliash Hossain</h5>
                        <span className="sub-text">Active 35m ago</span>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Profile;
