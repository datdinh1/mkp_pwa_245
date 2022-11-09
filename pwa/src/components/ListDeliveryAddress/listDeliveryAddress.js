import React, { useState } from 'react';
import styles from './listDeliveryAddress.module.scss';
import { useTranslation } from 'react-i18next';
import TextInput from '../../components/TextInput';
import { RotateCcw, Save } from 'react-feather';

const ListDeliveryAddress = () => {
    // const { t } = useTranslation('deliveryAddress');\
    const [isNew, setIsNew] = useState(false);

    return (
        <div className={styles.listDeliveryContainer}>
            {isNew === false ? (
                <>
                    <div className="py-5">
                        <h1 className="text-center mb-5">hoang dep trai</h1>
                        <div className={`${styles.addressWrap} mb-4`}>
                            <div className={styles.addressRadio}>
                                <input
                                    className={styles.inputRadio}
                                    type="radio"
                                />
                                <label />
                            </div>
                            <address className={styles.addressBox}>
                                <div className={`${styles.formTag} mb-3`}>
                                    <div className="row m-0">
                                        <p className="h5 p-2 m-0">
                                            Default Shipping Address
                                        </p>
                                    </div>
                                </div>
                                <p className="h3 text-bold mb-2">
                                    Hoang Nguyen
                                </p>
                                <p className={styles.normalText}>
                                    q, Khlong Thom, Khlong Thom Nuea, Krabi,
                                    81120
                                </p>
                                <p className={styles.normalText}>
                                    Tel. 0932093740
                                </p>
                                <div className="row m-0 text-blue mt-4">
                                    <button
                                        className={`${
                                            styles.configButton
                                        } mr-4`}
                                    >
                                        {' '}
                                        Edit{' '}
                                    </button>
                                    <button className={styles.configButton}>
                                        {' '}
                                        Delete{' '}
                                    </button>
                                </div>
                            </address>
                        </div>
                        <button
                            className={`${styles.addressButton} mx-auto mt-5`}
                            onClick={() => {
                                setIsNew(true);
                            }}
                        >
                            <span>Add New Address</span>
                        </button>
                    </div>
                </>
            ) : (
                <>
                    <div className="py-5" id="formContainer">
                        <h1 className="text-center mb-5">Delivery Address</h1>
                        <div className={styles.inputField}>
                            <label
                                className={` ${styles.labelField} h4 py-2 pr-4`}
                            >
                                dia chi 1
                            </label>
                            <TextInput />
                        </div>
                        <div className={styles.inputField}>
                            <label className="h4 py-2 pr-4">dia chi 2</label>
                            <TextInput />
                        </div>
                        <div className={styles.inputField}>
                            <label className="h4 py-2 pr-4">dia chi 3</label>
                            <TextInput />
                        </div>
                        <div className={styles.inputField}>
                            <label className="h4 py-2 pr-4">dia chi 4</label>
                            <TextInput />
                        </div>
                        <div className={styles.inputField}>
                            <label className="h4 py-2 pr-4">dia chi 5</label>
                            <TextInput />
                        </div>
                        <div className={styles.inputField}>
                            <label className="h4 py-2 pr-4">dia chi 6</label>
                            <TextInput />
                        </div>
                        <div className={styles.inputField}>
                            <label className="h4 py-2 pr-4">dia chi 7</label>
                            <TextInput />
                        </div>
                        <div className={styles.inputField}>
                            <label className="h4 py-2 pr-4">dia chi 8</label>
                            <TextInput />
                        </div>
                        <div className={`${styles.checkBoxRow} mb-4`}>
                            <div className="check-box">
                                <input
                                    className="check-box__input"
                                    type="checkbox"
                                />
                                <label className="check-box__label">
                                    {' '}
                                    Set as default Shipping Address{' '}
                                </label>
                            </div>
                        </div>
                        <div className={styles.buttonArea}>
                            <button
                                type="button"
                                className={styles.buttonDiscard}
                                onClick={() => {
                                    setIsNew(false);
                                }}
                            >
                                <i>
                                    <RotateCcw />
                                </i>{' '}
                                Discard
                            </button>
                            <button type="button" className={styles.buttonSave}>
                                <i>
                                    <Save />
                                </i>
                                Record
                            </button>
                        </div>
                    </div>
                </>
            )}
        </div>
    );
};

export default ListDeliveryAddress;
