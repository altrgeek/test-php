import React, { FC, Fragment, ReactNode } from 'react';

interface Props {
    label?: Nullable<string>;
    bottom?: boolean;
    children?: ReactNode;
}

const Separator: FC<{ label?: Nullable<string> }> = ({ label }) => {
    return label ? (
        <div className="chat-sap">
            <div className="chat-sap-meta">
                <span>{label}</span>
            </div>
        </div>
    ) : null;
};

const ChatBlock: FC<Props> = ({ label, children, bottom = false }) => {
    return (
        <Fragment>
            {!bottom && <Separator label={label} />}
            {children}
            {bottom && <Separator label={label} />}
        </Fragment>
    );
};

export default ChatBlock;
