import React, { useCallback } from 'react';
import { useTranslation } from 'react-i18next';
import { X as Icon, AlertCircle } from 'react-feather';
import { Form } from 'informed';
import { useAppContext } from '@magento/peregrine/lib/context/app';
import { isRequired } from '@magento/venia-ui/lib/util/formValidators';
import { useSignIn } from './useSignIn';
import { useToasts } from '@magento/peregrine';
import CREATE_CART_MUTATION from '@magento/venia-ui/lib/queries/createCart.graphql';
import GET_CUSTOMER_QUERY from 'src/layouts/context/user/getCustomer.graphql';
import SIGN_IN_MUTATION from '@magento/venia-ui/lib/queries/signIn.graphql';
import GET_CART_DETAILS_QUERY from '@magento/venia-ui/lib/queries/getCartDetails.graphql';

import TextInput from '../TextInput';
import SocialButton from '../SocialButton';
import IconContainer from '@magento/venia-ui/lib/components/Icon';

const AlertCircleIcon = <IconContainer src={AlertCircle} attrs={{ width: 18 }} />;

import styles from "./signIn.module.scss";

import logo from 'src/styles/images/logo.png'
import google from 'src/styles/images/google.svg'
import facebook from 'src/styles/images/facebook.svg'
import btnLoading from 'src/styles/images/btnLoading.svg'

const SignIn = () => {
    const { t } = useTranslation(['common']);
    const [appState, { closeDrawer, toggleDrawer }] = useAppContext();
    const [, { addToast }] = useToasts();
    const { drawer } = appState;
    const isOpen = drawer === 'sign-in';

    const talonProps = useSignIn({
        createCartMutation: CREATE_CART_MUTATION,
        customerQuery: GET_CUSTOMER_QUERY,
        getCartDetailsQuery: GET_CART_DETAILS_QUERY,
        signInMutation: SIGN_IN_MUTATION,
        closeDrawer: closeDrawer
    });

    const {
        errors,
        formRef,
        handleSubmit,
        isBusy
    } = talonProps;


    const errorMessage = errors.length
        ? errors
              .map(({ message }) => message)
              .reduce((acc, msg) => msg + '\n' + acc, '')
        : null;

    const handleSocialLogin = user => {
        console.log('aaaaaaaaaaaaaa',user);
    }

    const handleSocialLoginFailure = useCallback((err) => {
        addToast({
            type: 'warning',
            icon: AlertCircleIcon,
            message: err,
            timeout: 3000
        });
    }, [addToast]);

    return (
        <aside className={`modal-popup p-0 ${isOpen ? "active" : ""}`}>
            <div className={styles.content}>
                <div className='modal-popup__header'>
                    <img src={logo} alt='logo' />
                    <Icon
                        className='icon'
                        size={20}
                        color='#707070'
                        onClick={closeDrawer}
                    />
                </div>
                <h2 className='modal-popup__title size-xlarge'>
                    {t('Login')}
                </h2>
                <Form
                    ref={formRef}
                    onSubmit={handleSubmit}
                >
                    <div className='mb-4'>
                        <TextInput
                            placeholder='Email or Phone Number'
                            autoComplete='email'
                            field='email'
                            validate={isRequired}
                            validateOnBlur={true}
                        />
                    </div>
                    <div className='mb-4'>
                        <TextInput
                            placeholder='Password'
                            autoComplete='current-password'
                            field='password'
                            type='password'
                            validate={isRequired}
                            validateOnBlur={true}
                        />
                    </div>
                    <div className='d-flex justify-content-between align-items-center'>
                        <div className='check-box'>
                            <input
                                className='check-box__input'
                                type='checkbox'
                            />
                            <label className='check-box__label'>{t('Stay Login')}</label>
                        </div>
                        <p
                            className='size-medium color-blue-bold btn'
                            // onClick={ () => { toggleDrawer('forgot-password') }}
                        >
                            {t('Forgot your password?')}
                        </p>
                    </div>
                    <div className='d-flex flex-column align-items-center mb-3 mt-5'>
                        {errorMessage && <p className='message-error text-center mb-3'>{errorMessage}</p>}
                        <button
                            className='button button-main w-50'
                            type='submit'
                            disabled={isBusy}
                        >
                            { isBusy && <img className='mr-3' width={15} src={btnLoading} alt='facebook' /> }
                            {t('Login')}
                        </button>
                        <p className='text-center my-4 size-base'>{t('Or')}</p>
                        <div className='d-flex justify-content-center'>
                            { process.env.FACEBOOK_API_KEY ?
                                <SocialButton
                                    provider="facebook"
                                    appId={process.env.FACEBOOK_API_KEY}
                                    onLoginSuccess={handleSocialLogin}
                                    onLoginFailure={handleSocialLoginFailure}
                                >
                                    <img className='mx-3' width={40} src={facebook} alt='facebook' />
                                </SocialButton>
                                : <img className='mx-3' width={40} src={facebook} alt='facebook' />

                            }
                            { process.env.GOOGLE_API_KEY ?
                                <SocialButton
                                    provider="google"
                                    appId={process.env.GOOGLE_API_KEY}
                                    onLoginSuccess={handleSocialLogin}
                                    onLoginFailure={handleSocialLoginFailure}
                                >
                                    <img className='mx-3' width={40} src={google} alt='google' />
                                </SocialButton>
                                : <img className='mx-3' width={40} src={google} alt='google' />
                            }
                        </div>
                    </div>
                </Form>
            </div>
            <p className='py-4 m-0 size-medium text-center'>
                {t('Want to register?')}
                <span
                    className='btn size-medium color-blue-bold'
                    onClick={ () => { toggleDrawer('register') }}
                >
                    {t('Sign up now')}
                </span>
            </p>
        </aside>
    );
}

export default SignIn;
