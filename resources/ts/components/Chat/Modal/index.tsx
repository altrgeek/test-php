import React, { FC, MouseEventHandler, ReactNode } from 'react';
import { hideModal } from 'utils';

interface Props {
    id: string;
    title?: string;
    onSubmit?: MouseEventHandler<HTMLButtonElement>;
    onCancel?: MouseEventHandler<HTMLButtonElement>;
    submitLabel?: string;
    cancelLabel?: string;
    disabled?: boolean;
    children?: ReactNode;
}

const Modal: FC<Props> = ({
    id,
    title = 'Untitled popup',
    submitLabel = 'Submit',
    cancelLabel = 'Discard',
    onSubmit,
    onCancel,
    disabled,
    children
}) => {
    const handleModalDismiss: MouseEventHandler<HTMLButtonElement> = (event) => {
        event.preventDefault();

        // eslint-disable-next-line no-unused-expressions, @typescript-eslint/no-unused-expressions
        onCancel && onCancel(event);

        jQuery(`#${id}`).modal('hide');
    };

    return (
        <div className="modal fade opened toggled visible" id={id}>
            <div className="modal-dialog modal-md" role="document">
                <div className="modal-content">
                    <div className="modal-header">
                        <div className="modal-title">{title}</div>

                        <a href="#" className="close" aria-label="Close" onClick={hideModal(id)}>
                            <em className="icon ni ni-cross" />
                        </a>
                    </div>

                    <div className="modal-body">
                        <div className="form-validate is-alter">
                            <div className="row gx-4 gy-3">
                                {children}

                                <div className="col-12">
                                    <ul className="d-flex justify-content-between gx-4 mt-1">
                                        <li>
                                            <button
                                                id="addEvent"
                                                type="submit"
                                                className="btn btn-primary"
                                                disabled={disabled}
                                                onClick={onSubmit}
                                            >
                                                {submitLabel}
                                            </button>
                                        </li>
                                        <li>
                                            <button
                                                type="button"
                                                id="resetEvent"
                                                className="btn btn-danger btn-dim"
                                                onClick={handleModalDismiss}
                                            >
                                                {cancelLabel}
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Modal;
