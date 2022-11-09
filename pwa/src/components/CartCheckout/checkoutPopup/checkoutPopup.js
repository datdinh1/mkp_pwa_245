import { useAppContext } from '@magento/peregrine/lib/context/app';
import { isRequired } from '@magento/venia-ui/lib/util/formValidators';
import { Form } from 'informed';
import React, { useEffect, useRef, useState } from 'react';
import {
    ChevronLeft as LeftIcon,
    HelpCircle as FaqIcon,
    X as Icon
} from 'react-feather';
import { useUserContext } from 'src/layouts/context/user';
import TextInput from '../../../components/TextInput';
import DataNull from '../../DataNull/dataNull';
import styles from './checkoutPopup.module.scss';

const CheckoutPopup = () => {
    const [appState, { closeDrawer, toggleDrawer }] = useAppContext();
    const { drawer } = appState;
    const isOpen = drawer === 'discount';
    const [isOpenFaq, setIsOpenFaq] = useState(false);
    const [{ isSignedIn, currentUser }, { signOut }] = useUserContext();

    const FaqRef = useRef(null);

    // ON CLICK OUTSIDE SEARCH FORM
    useEffect(() => {
        function handleClickOutside(event) {
            if (FaqRef.current && !FaqRef.current.contains(event.target)) {
                setIsOpenFaq(false);
            } else {
            }
        }
        // Bind the event listener
        document.addEventListener('mousedown', handleClickOutside);

        return () => {
            // Unbind the event listener on clean up
            document.removeEventListener('mousedown', handleClickOutside);
        };
    }, [FaqRef]);

    return (
        <>
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
                        <h1 className={styles.titlePopup}>
                            Discounts and coupons
                        </h1>
                    </div>
                    <div className={styles.popupBody}>
                        {isSignedIn && currentUser ? (
                            <div className={styles.bodyContainer}>
                                <div className={styles.formCheckoutContainer}>
                                    <div className={styles.faq}>
                                        <i onClick={() => setIsOpenFaq(true)}>
                                            <FaqIcon
                                                className={styles.faqIcon}
                                            />
                                        </i>
                                    </div>
                                    <Form>
                                        <div className={styles.inputField}>
                                            <div className={styles.input}>
                                                <TextInput
                                                    placeholder={
                                                        'Enter the coupon code'
                                                    }
                                                    autoComplete="couponcode"
                                                    field="couponcode"
                                                    validate={isRequired}
                                                    validateOnBlur={true}
                                                />
                                            </div>
                                        </div>
                                        <div className={styles.buttonArea}>
                                            <button
                                                type="submit"
                                                className={styles.buttonSubmit}
                                            >
                                                agree
                                            </button>
                                        </div>
                                    </Form>
                                </div>
                                <div className={styles.listCouponContainer}>
                                    <DataNull
                                        notice="please try again"
                                        title="No coupon found"
                                    />
                                </div>
                            </div>
                        ) : (
                            <div className={styles.popupLogin}>
                                <div className={styles.loginTitle}>
                                    <p className={styles.titleText}>
                                        Login or Register
                                    </p>
                                    <p className={styles.titleText}>
                                        friend use discount code
                                    </p>
                                </div>
                                <div className={styles.loginButtonArea}>
                                    <button
                                        type="button"
                                        className={styles.loginButton}
                                        onClick={() => toggleDrawer('sign-in')}
                                    >
                                        Login/Register
                                    </button>
                                </div>
                            </div>
                        )}
                    </div>
                </div>
            </aside>
            <aside
                className={`modal-popup p-0 ${isOpenFaq ? `active ` : ''}`}
                ref={FaqRef}
            >
                <div className={styles.faqContainer}>
                    <div className={styles.faqHeader}>
                        <h2 className={styles.titleText}>FAQ</h2>
                        <Icon
                            className="icon"
                            size={25}
                            color="#707070"
                            onClick={() => setIsOpenFaq(false)}
                            style={{ cursor: 'pointer' }}
                        />
                    </div>
                    <div className={styles.faqBody}>
                        <div>
                            <p className={styles.faqText}>
                                How do I use the code?
                            </p>
                            <p className={styles.faqText}>
                                You must collect the discount code from another
                                page or type the code in the box above first.
                            </p>
                            <p className={styles.faqText}>
                                The code will appear for you to use on this
                                page.
                            </p>
                            <br />
                            <p className={styles.faqText}>
                                Where can I store the code?
                            </p>
                            <p className={styles.faqText}>
                                You can find Shopee discount codes on various
                                campaign pages.
                            </p>
                            <p className={styles.faqText}>
                                And in front of each store
                            </p>
                        </div>
                        <div className={styles.faqBtnArea}>
                            <button
                                type="button"
                                className={styles.btn}
                                onClick={() => setIsOpenFaq(false)}
                            >
                                Understand
                            </button>
                        </div>
                    </div>
                </div>
            </aside>
        </>
    );
};

export default CheckoutPopup;
