import { useAppContext } from '@magento/peregrine/lib/context/app';
import React from 'react';
import {
    ChevronRight as RightIcon,
    CreditCard as CreditCardIcon,
    MapPin as MapIcon
} from 'react-feather';
import AddressPopup from './AddressPopup';
import CashPopup from './CashPopup';
import styles from './infoCheckout.module.scss';

const InfoCheckout = () => {
    const [appState, { closeDrawer, toggleDrawer }] = useAppContext();
    const { drawer } = appState;

    return (
        <div className={styles.infoCheckoutContainer}>
            <div className={styles.infoCheckoutBox}>
                <div
                    className={styles.infoToggle}
                    onClick={() => toggleDrawer('address')}
                >
                    <div className={styles.left}>
                        <i>
                            <MapIcon className={styles.icon} />
                        </i>
                        <p className={styles.text}>No Address found</p>
                    </div>
                    <div className={styles.right}>
                        <i>
                            <RightIcon className={styles.icon} />
                        </i>
                    </div>
                </div>
            </div>
            <div className={styles.infoCheckoutBox}>
                <div
                    className={styles.infoToggle}
                    onClick={() => toggleDrawer('method-cash')}
                >
                    <div className={styles.left}>
                        <i>
                            <CreditCardIcon className={styles.icon} />
                        </i>
                        <p className={styles.text}>
                            Choose a payment method Cash on delivery
                        </p>
                    </div>
                    <div className={styles.right}>
                        <i>
                            <RightIcon className={styles.icon} />
                        </i>
                    </div>
                </div>
            </div>
            <div className={styles.infoCheckoutBox}>
                <div className={styles.infoCheckout}>
                    <div className={styles.infoPayment}>
                        <p className={styles.priceInfo}>Total</p>
                        <p className={styles.priceInfo}>฿15,491</p>
                    </div>
                    <div className={styles.infoPayment}>
                        <p className={styles.priceInfo}>Discount</p>
                        <p className={styles.priceInfo}>฿0</p>
                    </div>
                    <div className={styles.infoPayment}>
                        <p className={styles.priceInfo}>Shipping cost</p>
                        <p className={styles.priceInfo}>฿5</p>
                    </div>
                    <div className={styles.infoPayment}>
                        <p className={`${styles.priceInfo} ${styles.total}`}>
                            Total price
                        </p>
                        <p className={`${styles.priceInfo}  ${styles.total}`}>
                            ฿15,496
                        </p>
                    </div>
                </div>
            </div>

            <CashPopup />
            <AddressPopup />
        </div>
    );
};

export default InfoCheckout;
