import { useToasts } from '@magento/peregrine';
import { useAppContext } from '@magento/peregrine/lib/context/app';
import { default as React } from 'react';
import { useHistory } from 'react-router-dom';
import { useUserContext } from 'src/layouts/context/user';
import NURSE from '../../styles/images/nurse.png';
import CheckboxInput from '../CheckboxInput/checkboxInput';
import styles from './cartCheckout.module.scss';
import { ChevronRight as RightIcon } from 'react-feather';
import CheckoutPopup from './checkoutPopup/checkoutPopup';

const CartCheckout = ({ data, handleCheckProduct, listProductChecked }) => {
    const allProduct =
        data
            .map(item => item.product)
            .reduce((acc, cur) => [...acc, ...cur], []) || [];

    const history = useHistory();
    const [, { addToast }] = useToasts();
    const [, { toggleDrawer }] = useAppContext();
    const [{ isSignedIn, currentUser }, { signOut }] = useUserContext();

    const handlePay = () => {
        if (isSignedIn && currentUser) {
            history.push('/checkout');
        } else {
            toggleDrawer('sign-in');
            addToast({
                type: 'error',

                actionText: 'Ok',
                onAction: async removeToast => {
                    try {
                        removeToast();
                    } catch (error) {
                        console.error(error);
                    }
                },
                message: 'You must login to checkout',
                timeout: 5000
            });
        }
    };
    return (
        <div className={styles.checkoutContainer}>
            <div className={styles.top}>
                <div className={styles.checkoutTitle}>
                    <img src={NURSE} alt="nurse" className={styles.titleImg} />
                    <h5 className={styles.titleText}>Nurse discount code</h5>
                </div>
                <div
                    className={styles.checkoutTitle}
                    onClick={
                        listProductChecked.length > 0
                            ? () => toggleDrawer('discount')
                            : null
                    }
                >
                    <h5
                        className={`${styles.titleText} ${
                            listProductChecked.length > 0
                                ? styles.popup
                                : styles.disabled
                        }`}
                    >
                        Select a discount code
                        <RightIcon className={styles.rightIcon} />
                    </h5>
                </div>
            </div>
            <div className={styles.bottom}>
                <div className={styles.checkoutField}>
                    <CheckboxInput
                        title={'select all'}
                        isChecked={
                            allProduct.length === listProductChecked.length
                                ? true
                                : false
                        }
                        id={allProduct.map(item => item.id)}
                        handleCheck={handleCheckProduct}
                        type={'ALL'}
                    />
                </div>
                <div className={styles.checkoutContent}>
                    <p className={styles.priceText}>Total price</p>
                    <p className={`${styles.priceText} ${styles.priceNumber}`}>
                        ฿10,269
                    </p>
                </div>
                <div className={styles.checkoutButton}>
                    <button
                        type="button"
                        className={styles.buttonPay}
                        onClick={handlePay}
                        disabled={listProductChecked.length < 1 ? true : false}
                    >
                        Pay
                    </button>
                </div>
            </div>
            <CheckoutPopup />
        </div>
    );
};

export default CartCheckout;
