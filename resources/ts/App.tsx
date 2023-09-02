import React, { FC, Fragment } from 'react';
import Chat from 'components/Chat/LazyChat';
import Notifications from 'components/Notifications/LazyNotifications';
import Meeting from 'components/Meeting/LazyMeeting';

const App: FC = () => {
    return (
        <Fragment>
            <Chat />
            <Notifications />
            <Meeting />
        </Fragment>
    );
};

export default App;
