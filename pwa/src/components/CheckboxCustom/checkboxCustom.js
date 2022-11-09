import React from 'react';
import styles from './checkboxCustom.module.scss';

const CheckBoxCustom = ({ id }) => {
    return (
        <div className={styles.container}>
            <label className={styles.switch} htmlFor={`checkboxCustom ${id}`}>
                <input type="checkbox" id={`checkboxCustom ${id}`} />
                <div className={`${styles.slider} ${styles.round}`} />
            </label>
        </div>
    );
};

export default CheckBoxCustom;
