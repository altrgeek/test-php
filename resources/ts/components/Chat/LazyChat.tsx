/* eslint-disable react/jsx-no-useless-fragment */
import React, { lazy, Suspense } from 'react';
import { createPortal } from 'react-dom';

const LazyChat = () => {
    const container = document.getElementById('chat_module');

    if (!container) return null;

    const Chat = lazy(() => import('./index'));

    return createPortal(
        <Suspense fallback={<></>}>
            <Chat />
        </Suspense>,
        container
    );
};

export default LazyChat;

