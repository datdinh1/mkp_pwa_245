import React from 'react'
import { useAppContext } from '@magento/peregrine/lib/context/app';

export const useAddPaymentMethod = ({popup}) => {

    const [appState, { closeDrawer, toggleDrawer }] = useAppContext();
    const { drawer } = appState;
    const isOpen = drawer === popup;

  return ({
    isOpen,
  })
}