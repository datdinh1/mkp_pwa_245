import React from 'react';
import DATA_NULL from '../../styles/images/notfound.png';
import styles from './dataNull.module.scss';

const DataNull = ({ title, notice }) => {
    return (
        <div className={styles.dataNullContainer}>
            <div className={styles.dataNullImage}>
                <img
                    src={DATA_NULL}
                    alt="not found"
                    className={styles.dataNullImg}
                    loading="lazy"
                />
            </div>
            <div className={styles.dataNullContent}>
                <h5 className={styles.dataNullTitle}>
                    {title ? title : 'No result found'}
                </h5>
                <p className={styles.dataNullText}>
                    {notice ? notice : 'Go shopping and back later'}
                </p>
            </div>
        </div>
    );
};

export default DataNull;
