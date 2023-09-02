import React, { Dispatch, FC, MouseEventHandler, SetStateAction, useMemo } from 'react';
import classnames from 'classnames';
import { copyToClipboard } from 'utils/clipboard';

interface Props {
    opened: boolean;
    setOpened: Dispatch<SetStateAction<boolean>>;
}
const SharingModal: FC<Props> = ({ opened, setOpened }) => {
    const meetingLink = useMemo(() => window.__cogni.session.link, []);

    const closeModal: MouseEventHandler<HTMLButtonElement> = (event) => {
        event.preventDefault();
        setOpened(false);
    };

    const copyLink: MouseEventHandler<HTMLButtonElement> = (event) => {
        event.preventDefault();
        if (!meetingLink) return;

        copyToClipboard(meetingLink);
    };

    return (
        <div
            className={classnames(
                'absolute bottom-2.5 left-2.5 z-30 hidden md:block w-96 p-5 bg-white rounded-lg text-black transition-all',
                { 'opacity-100 visible': opened && meetingLink },
                { 'opacity-0 invisible': !(opened && meetingLink) }
            )}
        >
            <div className="flex items-center justify-between select-none">
                <h4 className="text-xl">Your meeting&apos;s ready</h4>

                <button
                    type="button"
                    className="flex items-center justify-center h-10 w-10 text-xl hover:bg-[#00000020] rounded-full transition-colors"
                    onClick={closeModal}
                >
                    <i className="fal fa-times" aria-label="Close" />
                </button>
            </div>

            <div className="flex flex-col items-stretch mt-3 mb-5 space-y-2">
                <p className="text-sm leading-snug text-gray-600 select-none">
                    Share this meeting link with others you want in the meeting
                </p>

                <div className="flex items-center justify-between w-full h-12 px-2.5 bg-gray-200 rounded-md space-x-3.5">
                    <p className="line-clamp-1">{meetingLink}</p>
                    <button
                        type="button"
                        className="flex flex-shrink-0 items-center justify-center h-10 w-10 text-lg tex-gray-700 rounded-full hover:bg-[#00000020] select-none"
                        onClick={copyLink}
                        aria-label="Copy meeting link"
                    >
                        <i className="far fa-copy" />
                    </button>
                </div>
            </div>

            <div className="flex items-center justify-between space-x-3 select-none">
                <i className="text-xl text-blue-600 fas fa-shield-check" aria-hidden="true" />
                <p className="text-xs text-gray-600">
                    People who use this meeting link must get your permission before they can join.
                </p>
            </div>

            <span className="block mt-5 text-sm text-gray-500 select-none">
                Joined as {window.__cogni.user.email}
            </span>
        </div>
    );
};

export default SharingModal;
