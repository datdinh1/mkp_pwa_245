import React from 'react';
import {
    INTERNAL_ERROR,
    NOT_FOUND,
    useMagentoRoute
} from '@magento/peregrine/lib/talons/MagentoRoute';

import { fullPageLoadingIndicator } from '@magento/venia-ui/lib/components/LoadingIndicator';
import NotFound from 'src/components/NotFound';

const MagentoRoute = () => {
    const talonProps = useMagentoRoute();
    const { component: RootComponent, id, isLoading, routeError } = talonProps;

    if (isLoading) {
        return fullPageLoadingIndicator;
    } else if (RootComponent) {
        return <RootComponent id={id} />;
    } else if (routeError === NOT_FOUND) {
        return <NotFound />;
    }

    return <NotFound />;
};

export default MagentoRoute;
