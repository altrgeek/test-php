import React, { FC, MouseEventHandler, Dispatch, SetStateAction } from 'react';
import classnames from 'classnames';

interface Props {
    opened: boolean;
    setOpened: Dispatch<SetStateAction<boolean>>;
    guestJoined?: boolean;
}
const InfoModal: FC<Props> = ({ opened, setOpened, guestJoined = false }) => {
    const closeModal: MouseEventHandler<HTMLButtonElement> = (event) => {
        event.preventDefault();
        setOpened((o) => !o);
    };

    return (
        <div
            className={classnames(
                'left-2.5 top-2.5 right-2.5 bottom-[3.75rem] absolute z-20 bg-white rounded-xl md:top-10 md:bottom-20 md:right-[1.875rem] md:left-[unset] md:h-[unset] md:w-96 transform transition-transform p-5 text-black',
                {
                    'translate-x-0': opened,
                    'translate-x-[110%]': !opened
                }
            )}
        >
            <div className="flex justify-end">
                <button
                    type="button"
                    className="flex items-center justify-center h-10 w-10 text-xl hover:bg-[#00000015] rounded-full transition-colors"
                    onClick={closeModal}
                >
                    <i className="fal fa-times" aria-label="Close" />
                </button>
            </div>

            <div className="flex flex-col items-stretch space-y-6">
                <h3 className="font-medium text-xl text-gray-900">Participants</h3>
                <div className="flex flex-col items-stretch space-y-2">
                    <div className="flex space-x-3 items-center">
                        <img
                            src={window.__cogni.user.avatar || '/images/user.png'}
                            className="h-10 w-10 rounded-lg flex-shrink-0"
                            alt={window.__cogni.user.name}
                        />
                        <p className="font-medium flex-1 line-clamp-1">
                            {window.__cogni.user.name}
                        </p>
                    </div>
                    {guestJoined && (
                        <div className="flex space-x-3 items-center">
                            <img
                                src={window.__cogni.session.guest.avatar || '/images/user.png'}
                                className="h-10 w-10 rounded-lg flex-shrink-0"
                                alt={window.__cogni.session.guest.name}
                            />
                            <p className="font-medium flex-1 line-clamp-1">
                                {window.__cogni.session.guest.name}
                            </p>
                        </div>
                    )}
                </div>
            </div>
        </div>
    );
};

export default InfoModal;
