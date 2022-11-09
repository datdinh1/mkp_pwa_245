import { useMutation } from '@apollo/react-hooks';
import { useToasts } from '@magento/peregrine';
import { useAppContext } from '@magento/peregrine/lib/context/app';
import CREATE_CART_MUTATION from '@magento/venia-ui/lib/queries/createCart.graphql';
import GET_CART_DETAILS_QUERY from '@magento/venia-ui/lib/queries/getCartDetails.graphql';
import SIGN_IN_MUTATION from '@magento/venia-ui/lib/queries/signIn.graphql';
import { useCallback, useState } from 'react';
import GET_CUSTOMER_QUERY from 'src/layouts/context/user/getCustomer.graphql';
import { useSignIn } from '../SignIn/useSignIn';

export const UseRegister = ({ registerAccount }) => {
  const [appState, { closeDrawer, toggleDrawer }] = useAppContext();
  const [, { addToast }] = useToasts();
  const [isChecked, setIsChecked] = useState(false);
  const [isCateChoosed, setIsCateChoosed] = useState({
    email: true,
    mobile: false
  });

  const talonProps = useSignIn({
    createCartMutation: CREATE_CART_MUTATION,
    customerQuery: GET_CUSTOMER_QUERY,
    getCartDetailsQuery: GET_CART_DETAILS_QUERY,
    signInMutation: SIGN_IN_MUTATION,
    closeDrawer: closeDrawer
  });

  const { errors, formRef, handleSubmit, isBusy } = talonProps;

  const [createAccount, { data, loading, error }] = useMutation(
    registerAccount
  );

  const errorMessage =
    error !== undefined && error.length
      ? error
          .map(({ message }) => message)
          .reduce((acc, msg) => msg + '\n' + acc, '')
      : errors.length
      ? errors
          .map(({ message }) => message)
          .reduce((acc, msg) => msg + '\n' + acc, '')
      : null;

  const handleChooseCate = useCallback(
    ({ type }) => {
      switch (type) {
        case 'EMAIL':
          setIsCateChoosed({ email: true, mobile: false });
          break;
        case 'MOBILE':
          setIsCateChoosed({ email: false, mobile: true });
          break;
        default:
          break;
      }
    },
    [isCateChoosed]
  );

  const removeAccents = str => {
    var AccentsMap = [
      'aàảãáạăằẳẵắặâầẩẫấậ',
      'AÀẢÃÁẠĂẰẲẴẮẶÂẦẨẪẤẬ',
      'dđ',
      'DĐ',
      'eèẻẽéẹêềểễếệ',
      'EÈẺẼÉẸÊỀỂỄẾỆ',
      'iìỉĩíị',
      'IÌỈĨÍỊ',
      'oòỏõóọôồổỗốộơờởỡớợ',
      'OÒỎÕÓỌÔỒỔỖỐỘƠỜỞỠỚỢ',
      'uùủũúụưừửữứự',
      'UÙỦŨÚỤƯỪỬỮỨỰ',
      'yỳỷỹýỵ',
      'YỲỶỸÝỴ'
    ];
    for (var i = 0; i < AccentsMap.length; i++) {
      var re = new RegExp('[' + AccentsMap[i].substring(1) + ']', 'g');
      var char = AccentsMap[i][0];
      str = str.replace(re, char);
    }
    return str;
  };

  const handleRegister = useCallback(
    async ({ firstname, lastname, email, password, retypePassword }) => {
      try {
        const checkEmail = removeAccents(email);
        if (checkEmail === email) {
          await createAccount({
            variables: { firstname, lastname, email, password }
          });
          if (!error) {
            await handleSubmit({ email, password });
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
          }
        } else {
          await addToast({
            type: 'error',
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
            message:
              '{"errorMessage":""Email"is not a valid email address.","code":400}',
            timeout: 5000
          });
          await closeDrawer();
        }
      } catch (error) {
        await addToast({
          type: 'error',
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
          message: `${String(error).split(': ')[2]}`,
          timeout: 5000
        });
        await closeDrawer();
      }
    },
    [registerAccount]
  );

  return {
    handleRegister,
    handleChooseCate,
    errorMessage,
    isChecked,
    setIsChecked,
    isCateChoosed,
    isBusy,
    formRef,
    dataRegister: data,
    registerLoading: loading
  };
};
