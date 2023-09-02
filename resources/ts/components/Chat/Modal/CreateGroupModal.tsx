import React, { FC, useState } from 'react';
import Modal from './index';
import ModalField from './ModalField';

interface Props {
    id?: string;
    title?: string;
}

const CreateGroupModal: FC<Props> = ({
    id = 'createChatGroupModal',
    title = 'Create new group'
}) => {
    const [name, setName] = useState('');

    return (
        <Modal {...{ id, title }}>
            <ModalField>
                <input
                    type="text"
                    className="form-control"
                    onChange={(event) => setName(event.target.value)}
                    value={name}
                    required
                />
            </ModalField>
        </Modal>
    );
};

export default CreateGroupModal;
