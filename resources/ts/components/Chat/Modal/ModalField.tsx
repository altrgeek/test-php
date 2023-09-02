import React, { FC, ReactNode } from 'react';
import classnames from 'classnames';

interface Props {
    label?: string;
    width?: 'full' | 'half';
    children?: ReactNode;
}

const ModalField: FC<Props> = ({ label, width = 'full', children }) => {
    return (
        <div className={classnames({ 'col-12': width === 'full', 'col-6': width === 'half' })}>
            <div className="form-group">
                {label && <div className="form-label">{label}</div>}
                <div className="form-control-wrap">{children}</div>
            </div>
        </div>
    );
};

export default ModalField;
