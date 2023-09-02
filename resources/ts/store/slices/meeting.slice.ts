import { createSlice, PayloadAction } from '@reduxjs/toolkit';

declare type ControlState = { enabled: boolean; error: boolean };
export declare type InfoTab = 'participants' | 'meeting';

interface State {
    link: Nullable<string>;
    controls: {
        audio: ControlState;
        video: ControlState;
    };
    sharing: {
        visible: boolean;
    };
    info: {
        visible: boolean;
        tab: InfoTab;
    };
    emotion: {
        text: string;
        status: 'idle' | 'loading' | 'success' | 'error';
    };
}

const initialState: State = {
    link: null,
    controls: {
        audio: { enabled: true, error: false },
        video: { enabled: true, error: false }
    },
    sharing: {
        visible: false
    },
    info: {
        visible: false,
        tab: 'meeting'
    },
    emotion: {
        text: '',
        status: 'idle'
    }
};

const meetingSlice = createSlice({
    name: 'meeting',
    initialState,
    reducers: {
        toggleSharingModal(state, { payload }: PayloadAction<boolean | undefined>) {
            state.sharing.visible =
                typeof payload !== 'undefined' ? payload : !state.sharing.visible;
        },
        toggleInfoModal(state, { payload }: PayloadAction<boolean | undefined>) {
            state.info.visible = typeof payload !== 'undefined' ? payload : !state.info.visible;
        },
        setMeetingLink(state, { payload }: PayloadAction<Nullable<string>>) {
            state.link = payload;
        },
        setInfoTab(state, { payload }: PayloadAction<InfoTab>) {
            state.info.tab = payload;
        },
        toggleAudio(state, { payload }: PayloadAction<boolean | undefined>) {
            state.controls.audio.enabled =
                typeof payload !== 'undefined' ? payload : !state.controls.audio.enabled;
        },
        toggleVideo(state, { payload }: PayloadAction<boolean | undefined>) {
            state.controls.video.enabled =
                typeof payload !== 'undefined' ? payload : !state.controls.video.enabled;
        },
        setEmotionText(state, { payload }: PayloadAction<string | null>) {
            state.emotion.text = payload || '';
        },
        setEmotionStatus(
            state,
            { payload }: PayloadAction<'idle' | 'loading' | 'success' | 'error'>
        ) {
            state.emotion.status = payload;
        }
    }
});

export const {
    setMeetingLink,
    toggleSharingModal,
    setInfoTab,
    toggleInfoModal,
    toggleAudio,
    toggleVideo,
    setEmotionStatus,
    setEmotionText
} = meetingSlice.actions;

export default meetingSlice.reducer;
