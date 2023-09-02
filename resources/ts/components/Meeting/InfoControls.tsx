import React, { Dispatch, FC, MouseEventHandler, SetStateAction } from 'react';
import classnames from 'classnames';

interface Props {
    setOpened: Dispatch<SetStateAction<boolean>>;
    guestJoined?: boolean;
    className?: string;
}
const InfoControls: FC<Props> = ({ setOpened, guestJoined = false, className }) => {
    const toggleInfoPanel: MouseEventHandler<HTMLButtonElement> = (event) => {
        event.preventDefault();
        setOpened((o) => !o);
    };

    return (
        <div className={classnames('flex items-center space-x-1.5 select-none', className)}>
            <button
                type="button"
                className="h-10 w-10 hover:bg-[#FFFFFF20] rounded-full flex items-center justify-center relative"
                onClick={toggleInfoPanel}
            >
                <span className="absolute top-0 right-0 flex items-center justify-center w-5 h-5 text-xs transform translate-x-1 -translate-y-1 bg-[#5F6368] rounded-full">
                    {guestJoined ? 2 : 1}
                </span>
                <i className="text-lg far fa-user-friends" />
            </button>
        </div>
    );
};

export default InfoControls;
