import { useCallback, useRef, useState } from 'react';
import { useUserContext } from 'src/layouts/context/user';
import { useMutation } from '@apollo/react-hooks';
import { useCartContext } from '@magento/peregrine/lib/context/cart';
import { useAwaitQuery } from '@magento/peregrine/lib/hooks/useAwaitQuery';
import { useToasts } from '@magento/peregrine';

export const useSignIn = props => {
    const {
        createCartMutation,
        customerQuery,
        getCartDetailsQuery,
        setDefaultUsername,
        showCreateAccount,
        showForgotPassword,
        signInMutation,
        closeDrawer
    } = props;
    const [, { addToast }] = useToasts();
    const [isSigningIn, setIsSigningIn] = useState(false);

    const [, { createCart, getCartDetails, removeCart }] = useCartContext();
    const [
        { isGettingDetails, getDetailsError },
        { getUserDetails, setToken }
    ] = useUserContext();

    const [signIn, { error: signInError }] = useMutation(signInMutation, {
        fetchPolicy: 'no-cache'
    });
    const [fetchCartId] = useMutation(createCartMutation);
    const fetchUserDetails = useAwaitQuery(customerQuery);
    const fetchCartDetails = useAwaitQuery(getCartDetailsQuery);

    const errors = [];
    if (signInError) {
        errors.push(signInError.graphQLErrors[0]);
    }
    if (getDetailsError) {
        errors.push(getDetailsError);
    }

    const formRef = useRef(null);

    const handleSubmit = useCallback(
        async ({ email, password }) => {
            setIsSigningIn(true);
            try {
                // Sign in and save the token
                const response = await signIn({
                    variables: { email, password }
                });

                const token =
                    response && response.data.generateCustomerToken.token;

                await setToken(token);
                await getUserDetails({ fetchUserDetails });

                // Then remove the old, guest cart and get the cart id from gql.
                // TODO: This logic may be replacable with mergeCart in 2.3.4
                await removeCart();

                await createCart({
                    fetchCartId
                });

                await getCartDetails({ fetchCartId, fetchCartDetails });
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
                    message: 'You are logged in',
                    timeout: 5000
                });
                await closeDrawer();
            } catch (error) {
                if (process.env.NODE_ENV === 'development') {
                    console.error(error);
                }
            }
            setIsSigningIn(false);
        },
        [
            createCart,
            fetchCartDetails,
            fetchCartId,
            fetchUserDetails,
            getCartDetails,
            getUserDetails,
            removeCart,
            setToken,
            signIn
        ]
    );

    const handleForgotPassword = useCallback(() => {
        const { current: form } = formRef;

        if (form) {
            setDefaultUsername(form.formApi.getValue('email'));
        }

        showForgotPassword();
    }, [setDefaultUsername, showForgotPassword]);

    const handleCreateAccount = useCallback(() => {
        const { current: form } = formRef;

        if (form) {
            setDefaultUsername(form.formApi.getValue('email'));
        }

        showCreateAccount();
    }, [setDefaultUsername, showCreateAccount]);

    return {
        errors,
        formRef,
        handleCreateAccount,
        handleForgotPassword,
        handleSubmit,
        isBusy: isGettingDetails || isSigningIn
    };
};
