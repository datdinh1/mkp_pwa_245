import React from 'react';
import styles from './checkboxInput.module.scss';

const CheckboxInput = ({ title, handleCheck, isChecked, id, type }) => {
    return (
        <div className={styles.checkboxContainer}>
            <label className={styles.checkbox}>
                <input
                    name="checkbox"
                    type="checkbox"
                    checked={isChecked}
                    onChange={e => handleCheck({ data: id, e, type: type })}
                />
                <span>{title}</span>
            </label>
        </div>
    );
};

export default CheckboxInput;
