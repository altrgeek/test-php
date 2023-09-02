/* eslint-disable react/style-prop-object */
import React, { FC, SetStateAction } from 'react';
import { Tooltip } from 'flowbite-react';
import classnames from 'classnames';

interface Props {
    videoMuted: boolean;
    setVideoMuted: SetStateAction<boolean>;
    audioMuted: boolean;
    setAudioMuted: SetStateAction<boolean>;
}
const MeetingControls: FC<Props> = ({ audioMuted, videoMuted, setAudioMuted, setVideoMuted }) => {
    return (
        <div className="absolute flex items-center px-10 space-x-3 transform -translate-x-1/2 -translate-y-1/2 select-none top-1/2 left-1/2">
            <Tooltip
                content={videoMuted ? 'Disable camera' : 'Enable camera'}
                style="light"
                arrow={false}
            >
                <button
                    type="button"
                    className={classnames(
                        'flex items-center justify-center w-10 h-10 rounded-full relative',
                        {
                            'bg-white text-black': video.enabled && !video.error,
                            'bg-[#EA4335] text-white': !video.enabled || video.error
                        }
                    )}
                    onClick={handleVideoClick}
                >
                    {video.error && (
                        <span className="absolute top-0 right-0 flex items-center justify-center w-5 h-5 text-black transform translate-x-1 -translate-y-1 bg-yellow-300 rounded-full text-xxs">
                            <i className="fas fa-exclamation" aria-hidden="true" />
                        </span>
                    )}
                    <i className="far fa-video-slash" aria-label="Toggle video" />
                </button>
            </Tooltip>
            <Tooltip
                content={audio.enabled ? 'Disable microphone' : 'Enable microphone'}
                style="light"
                arrow={false}
            >
                <button
                    type="button"
                    className={classnames(
                        'flex items-center justify-center w-10 h-10 rounded-full relative',
                        {
                            'bg-white text-black': audio.enabled && !audio.error,
                            'bg-[#EA4335] text-white': !audio.enabled || audio.error
                        }
                    )}
                    onClick={handleAudioClick}
                >
                    {audio.error && (
                        <span className="absolute top-0 right-0 flex items-center justify-center w-5 h-5 text-black transform translate-x-1 -translate-y-1 bg-yellow-300 rounded-full text-xxs">
                            <i className="fas fa-exclamation" aria-hidden="true" />
                        </span>
                    )}
                    <i className="far fa-microphone-slash" />
                </button>
            </Tooltip>
            <Tooltip content="Leave call" style="light" arrow={false}>
                <button
                    type="button"
                    className="flex items-center justify-center w-16 h-10 bg-[#EA4335] rounded-full"
                    onClick={handleExit}
                >
                    <i
                        className="fas fa-phone"
                        style={{ transform: 'rotate(-135deg)' }}
                        aria-label="Toggle video"
                    />
                </button>
            </Tooltip>
        </div>
    );
};

export default MeetingControls;
