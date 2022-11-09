import React, { useCallback } from 'react';
import { useMutation } from '@apollo/react-hooks';
import { useTranslation } from 'react-i18next';
import { AlertCircle } from 'react-feather';
import { Link, resourceUrl, useHistory } from '@magento/venia-drivers';
import { useAppContext } from '@magento/peregrine/lib/context/app';
import { useUserContext } from 'src/layouts/context/user';
import { useToasts } from '@magento/peregrine';
import SIGN_OUT_MUTATION from '@magento/venia-ui/lib/queries/signOut.graphql';
import LoadingIndicator from '@magento/venia-ui/lib/components/LoadingIndicator';
import Icon from '@magento/venia-ui/lib/components/Icon';

const AlertCircleIcon = <Icon src={AlertCircle} attrs={{ width: 18 }} />;

const SignInSide = () => {
    const { t } = useTranslation(['common']);
    const [, { addToast }] = useToasts();
    const history = useHistory();
    const [, { toggleDrawer }] = useAppContext();
    const [{ isSignedIn, currentUser }, { signOut }] = useUserContext();
    const [revokeToken, { loading: isLoggingOut }] = useMutation(
        SIGN_OUT_MUTATION
    );

    const handleOpenPopup = useCallback(( type ) => {
        toggleDrawer(type);
    }, [toggleDrawer]);

    const handleSignOut = useCallback(() => {
        addToast({
            type: 'warning',
            dismissable: true,
            icon: AlertCircleIcon,
            actionText: t('Ok'),
            onAction: async removeToast => {
                try {
                    await signOut({ revokeToken });
                    removeToast();
                    await addToast({
                        type: 'info',
                        // dismissable: true,
                        // icon: AlertCircleIcon,
                        actionText: 'Ok',
                        onAction: async removeToast => {
                            try {
                                removeToast();
                            } catch (error) {
                                console.error(error);
                            }
                        },
                        message: 'You are logged out',
                        timeout: 5000
                    });
                    history.push(resourceUrl('/'));
                } catch (error) {
                    console.error(error);x
                }
            },
            message: t('Do you really want to log out?'),
            timeout: false
        });
    }, [addToast, revokeToken, history]);

    if( isLoggingOut ) {
        return <LoadingIndicator global={true} overlay={false} />;
    }

    return (
        <div className='container d-flex justify-content-end align-items-center py-3 size-base'>
            { isSignedIn && currentUser ? (
                <>
                    <Link
                        to={resourceUrl('/account')}
                    >
                        {`${currentUser.firstname} ${currentUser.lastname}`}
                    </Link>
                    <span className='px-3'>|</span>
                    <Link
                        to={"#"}
                        onClick={handleSignOut}
                    >
                        {t('Logout')}
                    </Link>
                </>
            ) : (
                <>
                    <Link
                        to={"#"}
                        onClick={ () => {handleOpenPopup('register')}}
                    >
                        {t("Register")}
                    </Link>
                    <span className='px-3'>|</span>
                    <Link
                        to={"#"}
                        onClick={ () => {handleOpenPopup('sign-in')}}
                    >
                        {t('Login')}
                    </Link>
                </>
            )}
        </div>
    );
}

export default SignInSide;
