import React from 'react';
import { useAppContext } from '@magento/peregrine/lib/context/app';
import styles from './cashPopup.module.scss';
import { ChevronLeft as LeftIcon } from 'react-feather';
import ListDeliveryAddress from '../../ListDeliveryAddress/listDeliveryAddress';

const CashPopup = () => {
    const [appState, { closeDrawer, toggleDrawer }] = useAppContext();
    const { drawer } = appState;
    const isOpenAddress = drawer === 'address';

    return (
        <aside
            className={`modal-popup p-0 modal-popup-right ${
                isOpenAddress ? `active active-slide-in-right` : ''
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
                    <h1 className={styles.titlePopup}>Delivery address</h1>
                </div>
                <div className={styles.popupBody}>
                    <ListDeliveryAddress />
                </div>
            </div>
        </aside>
    );
};

export default CashPopup;
