import { useAppContext } from '@magento/peregrine/lib/context/app';
import React from 'react';
import { ChevronLeft as LeftIcon } from 'react-feather';
import RadioInput from '../../RadioInput/radioInput';
import styles from './shippingMethodPopup.module.scss';
import SHIPPING_METHOD from 'src/styles/images/shipping_method.png';

const ShippingMethodPopup = () => {
    const [appState, { closeDrawer, toggleDrawer }] = useAppContext();
    const { drawer } = appState;
    const isOpen = drawer === 'shipping-method';
    return (
        <aside
            className={`modal-popup p-0 modal-popup-right ${
                isOpen ? `active active-slide-in-right` : ''
            }`}
        >
            <div className={`${styles.popupBox}`}>
                <div className={styles.popupHeader}>
                    <i>
                        <LeftIcon
                            className={styles.closeIcon}
                            onClick={closeDrawer}
                        />
                    </i>
                    <h1 className={styles.titlePopup}>Choose transport</h1>
                </div>
                <div className={styles.popupBody}>
                    <div className={styles.shippingMethod}>
                        <RadioInput
                            image={SHIPPING_METHOD}
                            title="delivered by"
                        />
                        <h5 className={styles.shippingPrice}>5THB</h5>
                    </div>
                    <div className={styles.shippingMethod}>
                        <RadioInput
                            image={SHIPPING_METHOD}
                            title="delivered by"
                        />
                        <h5 className={styles.shippingPrice}>20THB</h5>
                    </div>
                </div>
            </div>
        </aside>
    );
};

export default ShippingMethodPopup;
