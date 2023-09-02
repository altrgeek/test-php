/* eslint-disable jsx-a11y/no-noninteractive-element-interactions */
/* eslint-disable jsx-a11y/click-events-have-key-events */
/* eslint-disable jsx-a11y/anchor-is-valid */
import React, { FC, Fragment, MouseEventHandler } from 'react';
import classnames from 'classnames';
import { useAppDispatch } from 'hooks';
import { parseMessageTime } from 'utils';
import { loadChat } from 'store/thunks';
import { MessageType } from 'types/message';
import { useEffect } from 'react';

// Sent       - Message sent but not received by other person
// Delivered  - Message sent and received by other person but not opened yet
// Seen       - Message sent and seen by other person
// Unread     - New message received from other person
// Opened     - Seen other person's last message
declare type Status = 'unread' | 'opened' | 'sent' | 'delivered' | 'seen';

const ChatActions: FC = () => {
    return (
        <div className="chat-actions">
            <div className="dropdown">
                <a
                    href="#"
                    className="btn btn-icon btn-sm btn-trigger dropdown-toggle"
                    data-toggle="dropdown"
                >
                    <em className="icon ni ni-more-h" />
                </a>
                <div className="dropdown-menu dropdown-menu-right">
                    <ul className="link-list-opt no-bdr">
                        <li>
                            <a href="#">Mute</a>
                        </li>
                        {/* <li className="divider" />
                        <li>
                            <a href="#">Hide</a>
                        </li>
                        <li>
                            <a href="#">Delete</a>
                        </li>
                        <li className="divider" />
                        <li>
                            <a href="#">Mark as Unread</a>
                        </li>
                        <li>
                            <a href="#">Ignore Messages</a>
                        </li>
                        <li>
                            <a href="#">Block Messages</a>
                        </li> */}
                    </ul>
                </div>
            </div>
        </div>
    );
};

const ChatStatus: FC<{ status: Nullable<Status> }> = ({ status }) => {
    return (
        <Fragment>
            {/* New message received from other person */}
            {status === 'unread' && (
                <div className="status unread">
                    <em className="icon ni ni-bullet-fill" />
                </div>
            )}

            {/* Opened message of other person (nothing to show) */}

            {status === 'sent' && (
                <div className="status sent">
                    <em className="icon ni ni-check-circle" />
                </div>
            )}

            {/* Received but not opened by other person */}
            {status === 'delivered' && (
                <div className="status delivered">
                    <em className="icon ni ni-check-circle-fill" />
                </div>
            )}

            {/* Seen by other person */}
            {status === 'seen' && (
                <div className="status seen">
                    <em className="icon ni ni-check-circle-fill text-info" />
                </div>
            )}
        </Fragment>
    );
};

interface Props {
    id: string | number;
    type: 'group' | 'individual' | 'contact';
    icon?: Nullable<string>;
    online?: Nullable<boolean>;
    name: string;
    message?: Nullable<{
        time: number;
        type: MessageType;
        text: string;
        status: Nullable<Status>;
        deleted?: boolean;
    }>;
    preview?: boolean;
}
const ChatTile: FC<Props> = ({ id, type, icon, online, name, message, preview ,index}) => {
    const dispatch = useAppDispatch();

    const handleActivation: MouseEventHandler<HTMLLIElement> = (event) => {
        event.preventDefault();

        
    };

    
    useEffect(() => {
        if(index === 0){
            dispatch(loadChat({ id, type }));
        } 
    },[])

    return (
        <li
            className={classnames('chat-item', { 'is-unread': message?.status === 'unread' })}
            onClick={handleActivation}
        >
            <div className="chat-link chat-open">
                <div className="chat-media user-avatar">
                    {icon && <img src={icon} alt={name} />}

                    {typeof online !== 'undefined' && (
                        <span
                            className={classnames('status dot dot-lg', {
                                'dot-gray': !online,
                                'dot-success': online
                            })}
                        />
                    )}
                </div>
                <div className="chat-info">
                    <div className="chat-from">
                        <div
                            className="name"
                            style={{
                                maxWidth: '15ch',
                                overflow: 'hidden',
                                whiteSpace: 'nowrap',
                                textOverflow: 'ellipsis'
                            }}
                        >
                            {name}
                        </div>
                        {message && <span className="time">{parseMessageTime(message.time)}</span>}
                    </div>
                    {message && (
                        <div className="chat-context">
                            <div className="text">
                                {message.deleted && (
                                    <p>
                                        <em className="fas fa-ban" />
                                        <em>This message is deleted</em>
                                    </p>
                                )}
                                {!message.deleted && (
                                    <p>
                                        {message.type === 'image' && (
                                            <span>
                                                <i className="fas fa-image" /> Image
                                            </span>
                                        )}
                                        {message.type === 'document' && (
                                            <span>
                                                <i className="fas fa-file" /> Document
                                            </span>
                                        )}
                                        {message.type === 'text' && message.text}
                                    </p>
                                )}
                            </div>
                            {!message.deleted && <ChatStatus status={message.status} />}
                        </div>
                    )}

                    {!preview && <ChatActions />}
                </div>
            </div>
        </li>
    );
};

export default ChatTile;
