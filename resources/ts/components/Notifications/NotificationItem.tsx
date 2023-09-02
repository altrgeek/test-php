import moment from 'moment';
import React, { FC } from 'react';
import { Notification } from 'types/notification';

interface Props {
    notification: Notification;
}
const NotificationItem: FC<Props> = ({ notification: { title, time, url } }) => {
    return (
        <a href={url || '#'} className="nk-notification-item dropdown-inner">
            <div className="nk-notification-icon">
                <em className="icon icon-circle bg-warning-dim ni ni-curve-down-right" />
            </div>
            <div className="nk-notification-content">
                <div className="nk-notification-text">{title}</div>
                <div className="nk-notification-time">{moment(time).fromNow()}</div>
            </div>
        </a>
    );
};

export default NotificationItem;
