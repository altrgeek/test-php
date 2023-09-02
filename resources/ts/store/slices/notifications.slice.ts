import { createAsyncThunk, createSlice, PayloadAction } from '@reduxjs/toolkit';
import moment from 'moment';
import { BroadCastedNotification, DatabaseNotification, Notification } from 'types/notification';

interface State {
    items: Notification[];
}

const initialState: State = {
    items: []
};

export const fetchInitialNotifications = createAsyncThunk(
    'notifications/fetch-initial-notifications',
    async () => {
        const response = await sanctum<APIResponse<DatabaseNotification[]>>(
            'notifications?count=5'
        );

        return response.data.data;
    }
);

export const markNotificationsAsRead = createAsyncThunk(
    'notifications/mark-notifications-as-read',
    async () => {
        await sanctum('notifications/read', { method: 'PUT' });
    }
);

export const deleteNotifications = createAsyncThunk(
    'notifications/delete-notifications',
    async () => {
        await sanctum('notifications/delete', { method: 'DELETE' });
    }
);

const notificationSlice = createSlice({
    name: 'notifications',
    initialState,
    reducers: {
        clearNotifications(state) {
            state.items = [];
        },
        addNotification(state, action: PayloadAction<BroadCastedNotification>) {
            const notification: Notification = {
                title: action.payload.title || 'Untitled notification',
                description: action.payload.description,
                icon: action.payload.icon,
                url: action.payload.url,
                time: moment().unix() * 1000
            };

            state.items.push(notification);
        }
    },
    extraReducers(builder) {
        builder.addCase(markNotificationsAsRead.fulfilled, (state) => {
            state.items.length = 0;
        });
        builder.addCase(deleteNotifications.fulfilled, (state) => {
            state.items.length = 0;
        });
        builder.addCase(fetchInitialNotifications.fulfilled, (state, action) => {
            console.log(action.payload);

            state.items = action.payload.map(({ created_at, data }) => {
                return {
                    title: data.title || 'Untitled notification',
                    description: data.description,
                    icon: data.icon,
                    url: data.url,
                    time: moment(created_at).unix() * 1000
                };
            });
        });
    }
});

export const { addNotification, clearNotifications } = notificationSlice.actions;

export default notificationSlice.reducer;
