import { useAppSelector } from 'hooks';
import React, { FC, Fragment } from 'react';
import ChatTile from './ChatTile';

const SearchedChats: FC = () => {
    const results = useAppSelector((state) => state.chat.search.data);
    const status = useAppSelector((state) => state.chat.search.status);
    const error = useAppSelector((state) => state.chat.search.error);

    return (
        <ul className="chat-list">
            {status === 'loading' && <span>Searching...</span>}
            {status === 'error' && (
                <span className="text-danger">{error || 'Could not search chats!'}</span>
            )}

            {status === 'success' && (
                <Fragment>
                    {results.groups.map(({ icon, name, uid: id, type }) => {
                        return <ChatTile {...{ icon, name, id, type }} key={id} />;
                    })}

                    {results.contacts.map(({ id, name, avatar }) => {
                        return (
                            <ChatTile name={name} icon={avatar} id={id} type="contact" key={id} />
                        );
                    })}
                </Fragment>
            )}
        </ul>
    );
};

export default SearchedChats;
