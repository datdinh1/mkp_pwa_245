import React from 'react';
import {
    ToastContextProvider,
    WindowSizeContextProvider
} from '@magento/peregrine';

import AppContextProvider from '@magento/peregrine/lib/context/app';
import CartContextProvider from '@magento/peregrine/lib/context/cart';
import ErrorContextProvider from '@magento/peregrine/lib/context/unhandledErrors';
import CatalogContextProvider from '@magento/peregrine/lib/context/catalog';
import CheckoutContextProvider from '@magento/peregrine/lib/context/checkout';
import UserContextProvider from './user';

/**
 * List of context providers that are required
 *
 * @property {React.Component[]} contextProviders
 * @see @magento/venia-ui/lib/components/App/contextProvider.js
 * @see @magento/peregrine/lib/PeregrineContextProvider/peregrineContextProvider.js
 */
const contextProviders = [
    ErrorContextProvider,
    AppContextProvider,
    UserContextProvider,
    CatalogContextProvider,
    CartContextProvider,
    CheckoutContextProvider,

    WindowSizeContextProvider,
    ToastContextProvider
];

const ContextProvider = ({ children }) => {
    return contextProviders.reduceRight((memo, ContextProvider) => {
        return <ContextProvider>{memo}</ContextProvider>;
    }, children);
};

export default ContextProvider;
