/* eslint-disable react/jsx-no-useless-fragment */
import React, { lazy, Suspense } from 'react';
import { createPortal } from 'react-dom';

const LazyMeeting = () => {
    const container = document.getElementById('meetings_module');

    if (!container) return null;

    const Meeting = lazy(() => import('.'));

    return createPortal(
        <Suspense fallback={<></>}>
            <Meeting />
        </Suspense>,
        container
    );
};

export default LazyMeeting;
