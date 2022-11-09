import { useMutation } from '@apollo/react-hooks';
import { useToasts } from '@magento/peregrine';
import { useAppContext } from '@magento/peregrine/lib/context/app';
import { useState } from 'react';
import GET_CUSTOMER_QUERY from 'src/layouts/context/user/getCustomer.graphql';
import { useUserContext } from 'src/layouts/context/user';
import { useAwaitQuery } from '@magento/peregrine/lib/hooks/useAwaitQuery';

export const useProfile = ({ updateCustomerInfo, updatePasswordInfo }) => {
  const [isEdit, setIsEdit] = useState(false);
  const [, { addToast }] = useToasts();

  const [appState, { closeDrawer, toggleDrawer }] = useAppContext();

  const fetchUserDetails = useAwaitQuery(GET_CUSTOMER_QUERY);
  const [
    { isGettingDetails, getDetailsError },
    { getUserDetails, setToken }
  ] = useUserContext();

  const [
    updateCustomer,
    { data: dataUpdateInfo, loading: loadingUpdateInfo, error: errorUpdateInfo }
  ] = useMutation(updateCustomerInfo);

  const [
    updatePassword,
    { data: dataPassword, loading: loadingPassword, error: errorPassword }
  ] = useMutation(updatePasswordInfo);

  const handleUpdateInfo = async ({
    firstname,
    lastname,
    gender,
    date_of_birth
  }) => {
    try {
      await updateCustomer({
        variables: { firstname, lastname, gender, date_of_birth }
      });

      await setIsEdit(false);
      await addToast({
        type: 'info',
        actionText: 'Ok',
        onAction: async removeToast => {
          try {
            removeToast();
          } catch (error) {
            console.error(error);
          }
        },
        message: 'You are updated',
        timeout: 5000
      });
      await getUserDetails({ fetchUserDetails });
    } catch (error) {
      addToast({
        type: 'error',
        actionText: 'Ok',
        onAction: async removeToast => {
          try {
            removeToast();
          } catch (error) {
            console.error(error);
          }
        },
        message: 'You have failed to update',
        timeout: 5000
      });
    }
  };

  const handleUpdatePassword = async ({
    currentPassword,
    password: newPassword
  }) => {
    try {
      await updatePassword({
        variables: { currentPassword, newPassword }
      });
      await closeDrawer();
      await addToast({
        type: 'info',
        actionText: 'Ok',
        onAction: async removeToast => {
          try {
            removeToast();
          } catch (error) {
            console.error(error);
          }
        },
        message: 'Password has successfully been changed',
        timeout: 5000
      });
      return true;
    } catch (error) {
      await closeDrawer();
      await addToast({
        type: 'error',
        actionText: 'Ok',
        onAction: async removeToast => {
          try {
            removeToast();
          } catch (error) {
            console.error(error);
          }
        },
        message: `The password doesn't match this account. Verify the password and try again.`,
        timeout: 5000
      });
      return false;
    }
  };

  return {
    handleUpdateInfo,
    handleUpdatePassword,
    dataUpdateInfo,
    loadingUpdateInfo,
    errorUpdateInfo,
    isEdit,
    setIsEdit,
    dataPassword,
    loadingPassword,
    errorPassword
  };
};
