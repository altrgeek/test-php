import React, { FC, useCallback, useEffect, useState } from 'react';
import { debounce } from 'lodash';
import { useAppDispatch } from 'hooks';
import { searchChats } from 'store/thunks';
import { resetSearch } from 'store/slices/chat.slice';

const Search: FC = () => {
    const dispatch = useAppDispatch();
    const [text, setText] = useState('');

    // Debounce the search event and wait until the user has stopped typing
    // eslint-disable-next-line react-hooks/exhaustive-deps
    const handleChange = useCallback(
        debounce((phrase: string) => {
            if (phrase) dispatch(searchChats(phrase));
            else dispatch(resetSearch());
        }, 1000),
        [debounce]
    );

    useEffect(() => {
        handleChange(text);
    }, [text, handleChange]);

    return (
        <div className="nk-chat-aside-search">
            <div className="form-group">
                <div className="form-control-wrap">
                    <div className="form-icon form-icon-left">
                        <em className="icon ni ni-search" />
                    </div>
                    <input
                        type="text"
                        className="form-control form-round"
                        onChange={(event) => setText(event.target.value)}
                        value={text}
                        placeholder="Search by name"
                    />
                </div>
            </div>
        </div>
    );
};

export default Search;
