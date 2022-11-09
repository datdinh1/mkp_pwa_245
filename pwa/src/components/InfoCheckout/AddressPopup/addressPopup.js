import React from 'react';
import { useAppContext } from '@magento/peregrine/lib/context/app';
import styles from './addressPopup.module.scss';
import { ChevronLeft as LeftIcon } from 'react-feather';
import ListDeliveryAddress from '../../ListDeliveryAddress/listDeliveryAddress';
import RadioInput from '../../RadioInput/radioInput';

const AdressPopup = () => {
    const [appState, { closeDrawer, toggleDrawer }] = useAppContext();
    const { drawer } = appState;
    const isOpenMethodCash = drawer === 'method-cash';

    return (
        <aside
            className={`modal-popup p-0 modal-popup-right ${
                isOpenMethodCash ? `active active-slide-in-right` : ''
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
                    <div className={styles.popupRadio}>
                        <RadioInput title={'Cash on delivery'} />
                    </div>
                    <div className={styles.popupRadio}>
                        <RadioInput
                            title={
                                'Credit / Debit Card and Cash Payment (2C2P)'
                            }
                        />
                    </div>
                </div>
            </div>
        </aside>
    );
};

export default AdressPopup;
