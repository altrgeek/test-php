import React, { FC, Fragment, MouseEventHandler, useEffect } from 'react';
import classnames from 'classnames';
import { BroadCastedNotification } from 'types/notification';
import { useAppDispatch, useAppSelector } from 'hooks';
import {
    addNotification,
    fetchInitialNotifications,
    clearNotifications
} from 'store/slices/notifications.slice';
import NotificationItem from './NotificationItem';

const Notifications: FC = () => {
    const dispatch = useAppDispatch();
    const notifications = useAppSelector((state) => state.notifications.items);

    useEffect(() => {
        dispatch(fetchInitialNotifications());

        const channel = `users.${user.id}`;

        Echo.private(channel).notification((notification: BroadCastedNotification) => {
            dispatch(addNotification(notification));
        });

        return () => Echo.leave(channel);
    }, [dispatch]);

    const handleHandleMarkAsRead: MouseEventHandler<HTMLAnchorElement> = (event) => {
        event.preventDefault();

        console.log('Dispatching thunk');
        dispatch(clearNotifications());
    };

    return (
        <Fragment>
            <a
                href="#"
                className="dropdown-toggle nk-quick-nav-icon"
                data-bs-toggle="dropdown"
                aria-expanded="false"
            >
                <div
                    className={classnames('icon-status', {
                        'icon-status-danger': notifications.length,
                        'icon-status-na': notifications.length === 0
                    })}
                >
                    <em className="icon ni ni-bell" />
                </div>
            </a>
            <div
                className="dropdown-menu dropdown-menu-xl dropdown-menu-end"
                id="notificationsDropdown"
            >
                <div className="dropdown-head">
                    <span className="sub-title nk-dropdown-title">Notifications</span>
                    <a href="#" onClick={handleHandleMarkAsRead}>
                        Mark all as read
                    </a>
                </div>

                <div className="dropdown-body">
                    <div className="nk-notifications">
                        {notifications.map((item, index) => {
                            // eslint-disable-next-line react/no-array-index-key
                            return <NotificationItem notification={item} key={index} />;
                        })}
                    </div>
                </div>

                {/* <div className="dropdown-foot center">
                    <a href="#">View All</a>
                </div> */}
            </div>
        </Fragment>
    );
};

export default Notifications;
