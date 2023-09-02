import React from 'react';
import { createPortal } from 'react-dom';
import Notification from './index';

const LazyNotifications = () => {
    const container = document.getElementById('notifications_module');

    if (!container) return null;

    return createPortal(<Notification />, container);
};

export default LazyNotifications;
