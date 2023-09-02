/* eslint-disable jsx-a11y/anchor-is-valid */
import { FC, ReactNode } from 'react';
import SettingsDropdown from './SettingsDropdown';

const SettingsIcon: FC<{ children?: ReactNode }> = ({ children }) => {
    return (
        <div className="dropdown">
            <a
                href="#"
                className="btn btn-round btn-icon btn-light dropdown-toggle"
                data-toggle="dropdown"
            >
                <em className="icon ni ni-setting-alt-fill" />
            </a>
            <SettingsDropdown>{children}</SettingsDropdown>
        </div>
    );
};

export default SettingsIcon;
