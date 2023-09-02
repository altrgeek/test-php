import moment from 'moment';
import { groupBy } from 'lodash';
import { Activity } from 'types/message';
import { Chat } from 'types/chat';
import { MouseEventHandler } from 'react';

export const groupMessages = (messages: Activity[]) => {
    return groupBy(messages, (message) => {
        return moment(message.created_at).format('YYYY-MM-DD');
    }) as Record<string, Activity[]>;
};

export const chatSorter = (a: Chat, b: Chat): number => {
    // console.log({
    //     a: a.last_message?.created_at
    //         ? moment(a.last_message?.created_at).format('DD-MM-YYY HH:mm:ss')
    //         : 0,
    //     b: a.last_message?.created_at
    //         ? moment(b.last_message?.created_at).format('DD-MM-YYY HH:mm:ss')
    //         : 0
    // });

    if (!a.last_message && !b.last_message) {
        // console.log('None of the messages have timestamps!');
        return 0;
    }

    if (a.last_message && !b.last_message) {
        // console.log('a has timestamp but b does not have one');
        return -1;
    }

    if (b.last_message && !a.last_message) {
        // console.log('b has timestamp but a does not have one');
        return 1;
    }

    if (a.last_message && a.last_message.created_at > (b.last_message?.created_at || 0)) {
        // console.log('a timestamp is greater than b');
        return -1;
    }

    if (b.last_message && b.last_message.created_at > (a.last_message?.created_at || 0)) {
        // console.log('b timestamp is greater than a');
        return 1;
    }

    // console.log('both timestamps are equal');

    return 0;
};

export const parseMessageTime = (timestamp: number): string => {
    const current = moment();
    const time = moment(timestamp * 1000);

    if (current.unix() - time.unix() > 0 && current.unix() - time.unix() < 60) return 'now';
    if (current.format('DD-MM-YYYY') === time.format('DD-MM-YYYY')) return time.format('h:mm a');
    if (current.diff(time, 'days') === 1) return 'yesterday';
    if (current.diff(time, 'days') <= 6) return time.format('ddd');

    return moment.unix(timestamp).format('DD/MM/YYYY');
};

export const scrollMessageAreaToBottom = () => {
    const container = document.getElementById('messagesWrapperContainer');

    container?.animate({
        scrollTop: container.scrollHeight
    });
};

declare type ModalHandlerFn = <T extends HTMLElement = HTMLElement>(
    id: string
) => MouseEventHandler<T>;

export const showModal: ModalHandlerFn = (id: string) => {
    return (event) => {
        event.preventDefault();
        jQuery(`#${id}`).modal('show');
    };
};

export const hideModal: ModalHandlerFn = (id: string) => {
    return (event) => {
        event.preventDefault();
        jQuery(`#${id}`).modal('hide');
    };
};
