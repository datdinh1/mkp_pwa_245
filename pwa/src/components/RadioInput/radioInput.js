import React, { memo } from 'react';
import styles from './radioInput.module.scss';
const RadioInput = ({ title, isChecked, handleCheck, index, image }) => {
    return (
        <div className={styles.radioContainer}>
            <label className={styles.radio}>
                <input
                    name="radio"
                    type="radio"
                    checked={isChecked}
                    onChange={() => handleCheck({ index: index })}
                />
                <span className={image && styles.image}>
                    {title}
                    {image && (
                        <img src={image} alt="image" className={styles.img} />
                    )}
                </span>
            </label>
        </div>
    );
};

export default memo(RadioInput);
