import React from 'react';
import { ChevronLeft as LeftIcon } from 'react-feather';
import { Link } from 'react-router-dom';
import styles from './headerCheckout.module.scss';

const HeaderCheckout = () => {
    return (
        <header className={styles.headerCheckoutContainer}>
            <div className="container">
                <div className={styles.headerCheckoutBox}>
                    <div className={styles.headerLeft}>
                        <Link to="/">
                            <i>
                                <LeftIcon className={styles.iconHeader} />
                            </i>
                        </Link>
                    </div>
                    <div className={styles.headerMiddle}>
                        <h1 className={styles.headerTitle}>Checkout</h1>
                    </div>
                </div>
            </div>
        </header>
    );
};

export default HeaderCheckout;
