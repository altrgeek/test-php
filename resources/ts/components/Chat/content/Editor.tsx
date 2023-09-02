/* eslint-disable react/no-danger */
/* eslint-disable jsx-a11y/anchor-is-valid */
import { useAppDispatch, useAppSelector } from 'hooks';
import React, { ChangeEventHandler, FC, MouseEventHandler, useRef, useState } from 'react';
import { sendMessage } from 'store/thunks';
import { scrollMessageAreaToBottom } from 'utils';

const Editor: FC = () => {
    const dispatch = useAppDispatch();
    const chat = useAppSelector((state) => state.chat.active.data);

    const [text, setText] = useState('');

    const imageRef = useRef<HTMLInputElement>(null);
    const docRef = useRef<HTMLInputElement>(null);

    const handleTextMessageDelivery: MouseEventHandler<HTMLButtonElement> = (event) => {
        event.preventDefault();
        if (!text || !chat) return;

        dispatch(sendMessage({ chat_id: chat.uid, content: text, type: 'text' }))
            .unwrap()
            .then(() => {
                setText(() => '');
                scrollMessageAreaToBottom();
            })
            .catch((error) => console.log({ error }));
    };

    const handleImageMessageDelivery: ChangeEventHandler<HTMLInputElement> = (event) => {
        event.preventDefault();

        if (!chat || !event.target.files?.length) return;

        dispatch(sendMessage({ chat_id: chat.uid, type: 'image', content: event.target.files[0] }))
            .unwrap()
            .then(() => {
                scrollMessageAreaToBottom();
            });
    };

    const handleDocumentMessageDelivery: ChangeEventHandler<HTMLInputElement> = (event) => {
        event.preventDefault();

        if (!chat || !event.target.files?.length) return;

        dispatch(
            sendMessage({ chat_id: chat.uid, type: 'document', content: event.target.files[0] })
        )
            .unwrap()
            .then(() => {
                scrollMessageAreaToBottom();
            });
    };

    return (
        <div className="nk-chat-editor">
            <div className="nk-chat-editor-upload ml-n1">
                <a
                    href="#"
                    onClick={(event) => {
                        event.preventDefault();
                        imageRef.current?.click();
                    }}
                    className="btn btn-sm btn-icon btn-trigger text-primary toggle-opt"
                >
                    <em className="icon ni ni-img-fill" />
                </a>
                <a
                    href="#"
                    className="btn btn-sm btn-icon btn-trigger text-primary toggle-opt"
                    onClick={(event) => {
                        event.preventDefault();
                        docRef.current?.click();
                    }}
                >
                    <em className="icon ni ni-file" />
                </a>
            </div>

            <input
                type="file"
                style={{ display: 'none' }}
                name="image"
                onChange={handleImageMessageDelivery}
                ref={imageRef}
                accept="image/*"
            />
            <input
                type="file"
                style={{ display: 'none' }}
                name="doc"
                ref={docRef}
                onChange={handleDocumentMessageDelivery}
            />

            <div className="nk-chat-editor-form">
                <div className="form-control-wrap">
                    <textarea
                        className="form-control form-control-simple no-resize"
                        rows={1}
                        id="default-textarea"
                        placeholder="Type your message..."
                        value={text}
                        onChange={(event) => setText(event.target.value)}
                    />
                </div>
            </div>
            <ul className="nk-chat-editor-tools g-2">
                <li>
                    <a href="#" className="btn btn-sm btn-icon btn-trigger text-primary">
                        <em className="icon ni ni-happyf-fill" />
                    </a>
                </li>
                <li>
                    <button
                        type="button"
                        className="btn btn-round btn-primary btn-icon"
                        onClick={handleTextMessageDelivery}
                    >
                        <em className="icon ni ni-send-alt" />
                    </button>
                </li>
            </ul>
        </div>
    );
};

export default Editor;
