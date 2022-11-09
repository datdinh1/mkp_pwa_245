import combine from '@magento/venia-ui/lib/util/combineValidators';
import { isRequired,validateEmail } from '@magento/venia-ui/lib/util/formValidators';
import { Form } from 'informed';
import React from 'react';
import { useTranslation } from 'react-i18next';
import TextInput from '../../components/TextInput';
import styles from './deleteAccount.module.scss';

const DeleteAccount = () => {
    const { t } = useTranslation(['deleteAccount']);
    return (
        <div className={styles.DeleteAccountContainer}>
            <div className='container'>
                <div className={styles.DeleteAccountBody}>
                    <div className={styles.DeleteAccountTitle}>
                        <h1 className={styles.titleText}>{t('Delete Account')}</h1>
                    </div>
                    <div className={styles.formContainer}>
                        <Form>
                            <div className={styles.inputField}>
                                <label className={styles.labelField}>{t('Please enter a reason for deleting the account')} <span className={styles.fieldRequired}>*</span></label>
                                <div className={styles.input}>
                                <TextInput
                                    placeholder={t('Please enter additional information')}
                                    autoComplete='reason'
                                    field='reason'
                                    validate={combine([isRequired])}
                                    validateOnBlur={true}
                                />
                                </div>
                            </div>
                            <div className={styles.inputField}>
                                <label className={styles.labelField}>{t('Please enter your email')} <span className={styles.fieldRequired}>*</span></label>
                                <div className={styles.input}>
                                <TextInput
                                    placeholder={t('Email')}
                                    autoComplete='email'
                                    field='email'
                                    validate={combine([isRequired, validateEmail])}
                                    validateOnBlur={true}
                                />
                                </div>
                            </div>
                            <div className='d-flex align-items-center' style={{ margin: '30px 0 10px 0' }}>
                                <div className='check-box'>
                                    <input
                                        className='check-box__input'
                                        type='checkbox'
                                        // checked={isChecked}
                                        // onChange={() => setIsChecked(!isChecked)}
                                    />
                                    <label className='check-box__label'>
                                        {t('Agree to')}&nbsp;
                                        <a href='#' style={{ color: 'blue' }}>{t('terms and conditions')}</a>&nbsp;
                                        {t('for deleting a user account')}
                                    </label>
                                </div>
                            </div>
                            <div className={styles.buttonArea}>
                                <button type="submit" className={`${styles.buttonSubmit}`}>{t('Send')}</button>
                            </div>
                        </Form>
                    </div>
                </div>
            </div>
        </div>
    )
}

export default DeleteAccount