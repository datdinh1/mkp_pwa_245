import { useAppContext } from '@magento/peregrine/lib/context/app';
import combine from '@magento/venia-ui/lib/util/combineValidators';
import {
    hasLengthAtLeast, isRequired, validateConfirmPassword, validateEmail, validatePassword
} from '@magento/venia-ui/lib/util/formValidators';
import { Form } from 'informed';
import React from 'react';
import { X as Icon } from 'react-feather';
import { useTranslation } from 'react-i18next';
import btnLoading from 'src/styles/images/btnLoading.svg';
import facebook from 'src/styles/images/facebook.svg';
import google from 'src/styles/images/google.svg';
import logo from '../../styles/images/logo.png';
import TextInput from '../TextInput';
import styles from './register.module.scss';
import { UseRegister } from './useRegister';
import CREATE_CUSTOMER_QUERY from './createCustomer.graphql';

const Register = () => {
    const { t } = useTranslation(['common']);
    const [appState, { closeDrawer, toggleDrawer}] = useAppContext();
    const { drawer } = appState;
    const isOpen = drawer === 'register';
    
    const registerProps = UseRegister({
        registerAccount: CREATE_CUSTOMER_QUERY
    })
    
    
    const {
        handleRegister,
        handleChooseCate,
        errorMessage,
        isChecked, 
        setIsChecked,
        isCateChoosed,
        isBusy,
        formRef,
        dataRegister, 
        registerLoading
    } = registerProps

    const handleMobileSubmit = () => {
        console.log('hello')
    }
    
    return (
        <aside className={`modal-popup p-0 ${isOpen ? "active" : ""}`} >
            <div className={styles.content} >
                <div className='modal-popup__header'>
                    <img src={logo} alt='logo'  loading='lazy'/>
                    <Icon
                        className='icon'
                        size={20}
                        color='#707070'
                        onClick={closeDrawer}
                    />
                </div>
                <h2 className='modal-popup__title size-xlarge'>
                    {t('Register')}
                </h2>
                <div className={`${styles.buttonGroup}`}>
                    <button onClick={() => handleChooseCate({ type: 'EMAIL' })} type='button' className={`button ${isCateChoosed.email === true ? 'button-main' : 'button'} w-50 mr-4 ${styles.button}`}>{t('Email')}</button>
                    <button onClick={() => handleChooseCate({ type: 'MOBILE' })} type='button' className={`button ${isCateChoosed.mobile === true ? 'button-main' : 'button'} w-50 ${styles.button}`}>{t('Mobile Number')}</button>
                </div>
                <Form  ref={formRef} onSubmit={isCateChoosed.email === true ? handleRegister : ((isCateChoosed.mobile === true) && handleMobileSubmit)}>
                    {isCateChoosed.email === true && (
                        <div>
                            <div className='mb-4 d-flex justify-content-center align-items-center'>
                                <div className='mr-4'>
                                    <TextInput
                                        placeholder='First Name'
                                        autoComplete='firstname'
                                        field='firstname'
                                        validate={isRequired}
                                        validateOnBlur={true}
                                    />
                                </div>
                                <div>
                                    <TextInput
                                        placeholder='Last Name'
                                        autoComplete='lastname'
                                        field='lastname'
                                        validate={isRequired}
                                        validateOnBlur={true}
                                    />
                                </div>
                            </div>
                            <div className='mb-4'>
                                <TextInput
                                    placeholder='Email'
                                    autoComplete='email'
                                    field='email'
                                    validate={combine([isRequired, validateEmail])}
                                    validateOnBlur={true}
                                />
                            </div>
                            <div className='mb-4'>
                                <TextInput
                                    placeholder='Password'
                                    autoComplete='password'
                                    field='password'
                                    type="password"
                                    validate={combine([
                                        isRequired,
                                        [hasLengthAtLeast, 8],
                                        validatePassword
                                    ])}
                                    validateOnBlur={true}
                                />
                            </div>
                            <div className='mb-4'>
                                <TextInput
                                    placeholder='Retype Password'
                                    autoComplete='retypePassword'
                                    type="password"
                                    field='retypePassword'
                                    validate={combine([isRequired, validateConfirmPassword])}
                                    validateOnBlur={true}
                                />
                            </div>
                        </div>
                    )}

                    {isCateChoosed.mobile === true && (
                        <div>
                            <div className='mb-4 d-flex justify-content-center align-items-center'>
                                <div className='mr-4'>
                                    <TextInput
                                        placeholder='First Name'
                                        autoComplete='firstname'
                                        field='firstname'
                                        validate={isRequired}
                                        validateOnBlur={true}
                                    />
                                </div>
                                <div>
                                    <TextInput
                                        placeholder='Last Name'
                                        autoComplete='lastname'
                                        field='lastname'
                                        validate={isRequired}
                                        validateOnBlur={true}
                                    />
                                </div>
                            </div>
                            <div className='mb-4'>
                                <TextInput
                                    placeholder='Phone'
                                    autoComplete='phone'
                                    field='phone'
                                    validate={combine([isRequired])}
                                    validateOnBlur={true}
                                />
                            </div>
                            <div className='mb-4 d-flex justify-content-start align-items-start'>
                                <div className='mr-4 w-50'>
                                    <TextInput
                                        placeholder='OTP'
                                        autoComplete='otp'
                                        field='otp'
                                        validate={isRequired}
                                        validateOnBlur={true}
                                    />
                                </div>
                                <button
                                    className={`button button-main ${styles.buttonOTP}`}
                                    type='submit'
                                    disabled={true}
                                >
                                    {t('Send OTP')}
                                </button>
                            </div>
                            <div className='mb-4'>
                                <TextInput
                                    placeholder='Password'
                                    autoComplete='password'
                                    field='password'
                                    validate={combine([
                                        isRequired,
                                        [hasLengthAtLeast, 8],
                                        validatePassword
                                    ])}
                                    validateOnBlur={true}
                                />
                            </div>
                            <div className='mb-4'>
                                <TextInput
                                    placeholder='Retype Password'
                                    autoComplete='retypePassword'
                                    field='retypePassword'
                                    validate={combine([isRequired, validateConfirmPassword])}
                                    validateOnBlur={true}
                                />
                            </div>
                        </div>
                    )}
                    <div className='d-flex flex-column align-items-center mb-3 mt-5'>
                        {errorMessage && <p className='message-error text-center mb-3'>{errorMessage}</p>}
                        <button
                            className='button button-main w-50'
                            type='submit'
                            disabled={(isChecked === false || isBusy || registerLoading === true) && true}
                        >
                            { (isBusy || registerLoading )&& <img className='mr-3' width={15} src={btnLoading} alt='facebook'  loading='lazy'/> }
                            {t('Register')}
                        </button>
                        <p className='text-center my-4 size-base'>{t('Or')}</p>
                        <div className='d-flex justify-content-center'>
                            <img className='mx-3' width={40} src={facebook} alt='facebook'  loading='lazy'/>
                            <img className='mx-3' width={40} src={google} alt='google'  loading='lazy'/>
                        </div>
                    </div>
                </Form>
                <div className='d-flex justify-content-between align-items-center' style={{ margin: '30px 0 10px 0' }}>
                    <div className='check-box'>
                        <input
                            className='check-box__input'
                            type='checkbox'
                            checked={isChecked}
                            onChange={() => setIsChecked(!isChecked)}
                        />
                        <label className='check-box__label'></label>
                    </div>
                    <span className={styles.policy}>{t('Accept the terms of use of the website policy. and privacy policy')}&nbsp;
                        <a href='/cms/privacy-policy' target="_blank" style={{ color: 'red' }}>{t('Privacy Policy')}</a>
                    </span>
                </div>
            </div>
            <p className='py-4 m-0 size-medium text-center'>
                {t('Already a member?')}
                <span
                    className='btn size-medium color-blue-bold'
                    onClick={ () => {toggleDrawer('sign-in') }}
                >
                    {t('Log in')}
                </span>
            </p>
        </aside>
    );
}

export default Register;
