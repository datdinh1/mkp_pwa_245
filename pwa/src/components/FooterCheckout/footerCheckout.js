import React from 'react';
import styles from './footerCheckout.module.scss';

const FooterCheckout = ({ handleCheckout }) => {
    return (
        <div className={styles.footerCheckoutContainer}>
            <div className="container">
                <div className={styles.footerCheckoutBox}>
                    <div className={styles.boxLeft}>
                        <p className={styles.priceText}>
                            Total price&ensp;
                            <span className={styles.priceNumber}>
                                THB16,951
                            </span>
                        </p>
                    </div>
                    <div className={styles.boxRight}>
                        <button
                            className={styles.btnOrder}
                            onClick={handleCheckout}
                        >
                            Place Order
                        </button>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default FooterCheckout;
