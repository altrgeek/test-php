import { Chat, Contact, BaseChat, GroupChat } from 'types/chat';

export default interface ChatState {
    search: {
        text: string;
        status: AsyncState;
        results: {
            chats: Array<BaseChat & GroupChat>;
            contacts: Contact[];
        };
    };
    items: {
        status: AsyncState;
        chats: Chat[];
    };
    active_chat: {
        status: AsyncState;
        data: Nullable<Chat>;
        error: Nullable<string>;
    };
}
