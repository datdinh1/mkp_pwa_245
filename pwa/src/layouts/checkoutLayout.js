import { bool, shape, string } from 'prop-types';
import React from 'react';
import { useScrollLock } from 'src/hooks/useScrollLock';

// import Footer from '@magento/venia-ui/lib/components/Footer';
import { Title } from '@magento/venia-ui/lib/components/Head';
import Register from 'src/components/Register';
import SignIn from 'src/components/SignIn';
import HeaderCheckout from '../components/HeaderCheckout';

const Main = props => {
    const { children, isMasked, pageTitle } = props;

    useScrollLock(isMasked);

    return (
        <main>
            {pageTitle && <Title>{pageTitle}</Title>}
            <div
                className="bg-white"
                style={{ position: 'sticky', top: 0, zIndex: 2 }}
            >
                <HeaderCheckout />
            </div>
            <SignIn />
            <Register />
            <div className="page" style={{ paddingBottom: '30px' }}>
                {children}
            </div>
        </main>
    );
};

export default Main;

Main.propTypes = {
    classes: shape({
        page: string,
        page_masked: string,
        root: string,
        root_masked: string
    }),
    isMasked: bool
};
