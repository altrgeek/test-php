import { useAppSelector } from 'hooks';
import React, { FC, Fragment, ReactNode } from 'react';
import Editor from './Editor';
import Header from './Header';

interface Props {
    children?: ReactNode;
}

const Body: FC<Props> = ({ children }) => {
    const chat = useAppSelector((state) => state.chat.active.data);
    const status = useAppSelector((state) => state.chat.active.status);
    const error = useAppSelector((state) => state.chat.active.error);

    return (
        <div className="nk-chat-body">
            {status === 'success' && chat ? (
                <Fragment>
                    <Header />
                    <div className="nk-chat-panel" data-simplebar="init">
                        <div className="simplebar-wrapper" style={{ margin: '-20px -28px' }}>
                            <div className="simplebar-height-auto-observer-wrapper">
                                <div className="simplebar-height-auto-observer" />
                            </div>
                            <div className="simplebar-mask">
                                <div className="simplebar-offset" style={{ right: 0, bottom: 0 }}>
                                    <div
                                        className="simplebar-content-wrapper"
                                        style={{ height: '100%', overflow: 'hidden scroll' }}
                                    >
                                        <div
                                            className="simplebar-content"
                                            style={{ padding: '20px 28px' }}
                                            id="messagesWrapperContainer"
                                        >
                                            {children}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                className="simplebar-placeholder"
                                style={{ width: 'auto', height: '776px' }}
                            />
                        </div>
                        <div
                            className="simplebar-track simplebar-horizontal"
                            style={{ visibility: 'hidden' }}
                        >
                            <div
                                className="simplebar-scrollbar"
                                style={{ width: 0, display: 'none' }}
                            />
                        </div>
                        <div
                            className="simplebar-track simplebar-vertical"
                            style={{ visibility: 'visible' }}
                        >
                            <div
                                className="simplebar-scrollbar"
                                style={{
                                    height: '65px',
                                    transform: 'translate3d(0px, 0px, 0px)',
                                    display: 'block'
                                }}
                            />
                        </div>
                    </div>
                    <Editor />
                </Fragment>
            ) : (
                <div className="container text-center w-full pt-5 mt-5 text-muted">
                    {status === 'idle' && (
                        <span>Select a chat from sidebar to start messaging.</span>
                    )}
                    {status === 'loading' && <span>Fetching chat messages...</span>}
                    {status === 'error' && (
                        <strong className="text-danger">
                            {error || 'An error occurred while loading chat!'}
                        </strong>
                    )}
                </div>
            )}
        </div>
    );
};

export default Body;
