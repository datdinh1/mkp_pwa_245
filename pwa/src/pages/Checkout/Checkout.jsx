import React, { useEffect } from 'react';
import FooterCheckout from '../../components/FooterCheckout/footerCheckout';
import InfoCheckout from '../../components/InfoCheckout/infoCheckout';
import ListProductCheckout from '../../components/ListProductCheckout/listProductCheckout';
import styles from './checkout.module.scss';
import { useHistory } from 'react-router-dom';

const Checkout = () => {
    const history = useHistory();

    const handleCheckout = () => {
        history.push('/thankyou');
    };

    useEffect(() => {
        window.scrollTo(0, 0);
    }, []);
    return (
        <>
            <div className="container">
                <div className={styles.checkoutContainer}>
                    <section className={styles.checkoutLeft}>
                        <ListProductCheckout />
                    </section>
                    <section className={styles.checkoutRight}>
                        <InfoCheckout />
                    </section>
                </div>
            </div>
            {/* <Footer /> */}
            <FooterCheckout handleCheckout={handleCheckout} />
        </>
    );
};

export default Checkout;
