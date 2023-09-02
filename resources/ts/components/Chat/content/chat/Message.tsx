/* eslint-disable jsx-a11y/anchor-is-valid */
import { useAppDispatch } from 'hooks';
import React, { FC, Fragment, MouseEventHandler } from 'react';
import { deleteMessage } from 'store/thunks';
import { MessageType } from 'types/message';

const MessageActions: FC<{ id: number; chat: string }> = ({ id, chat }) => {
    const dispatch = useAppDispatch();

    const handleDelete: MouseEventHandler<HTMLAnchorElement> = (event) => {
        event.preventDefault();

        dispatch(deleteMessage({ chat_id: chat, message_id: id }))
            .unwrap()
            .catch((error) => {
                console.log({ error });
                alert('An error occurred while deleting message');
            });
    };

    return (
        <ul className="chat-msg-more">
            {/* <li className="d-none d-sm-block">
                <a href="#" className="btn btn-icon btn-sm btn-trigger">
                    <em className="icon ni ni-reply-fill" />
                </a>
            </li> */}
            <li>
                <div className="dropdown">
                    <a
                        href="#"
                        className="btn btn-icon btn-sm btn-trigger dropdown-toggle"
                        data-toggle="dropdown"
                    >
                        <em className="icon ni ni-more-h" />
                    </a>
                    <div className="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                        <ul className="link-list-opt no-bdr">
                            <li>
                                <a href="#" onClick={handleDelete}>
                                    <em className="icon ni ni-trash-fill" /> Delete
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    );
};

interface Props {
    id: number;
    chat: string;
    content: string;
    deleted?: boolean;
    type: MessageType;
    received: boolean;
}
const Message: FC<Props> = ({ id, chat, content, type, deleted, received }) => {
    return (
        <div className="chat-bubble">
            <div className="chat-msg">
                {deleted && (
                    <em>
                        <em className="fas fa-ban" />
                        &nbsp;This message is deleted
                    </em>
                )}
                {!deleted && (
                    <Fragment>
                        {type === 'image' && (
                            <img
                                src={`/storage/chat/${content}`}
                                className="w-100"
                                alt="Unavailable"
                            />
                        )}
                        {type === 'text' && content}
                        {type === 'document' && (
                            // eslint-disable-next-line jsx-a11y/click-events-have-key-events, jsx-a11y/no-static-element-interactions
                            <span
                                onClick={(event) => {
                                    event.preventDefault();
                                    window.open(content[0] === '/' ? content : `/${content}`);
                                }}
                            >
                                <i className="fas fa-file" />
                                Document
                            </span>
                        )}
                    </Fragment>
                )}
            </div>
            {!received && <MessageActions {...{ id, chat }} />}
        </div>
    );
};

export default Message;
