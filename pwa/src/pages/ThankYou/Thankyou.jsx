import React from 'react';
import styles from './thankYou.module.scss';
import { useHistory } from 'react-router-dom';

const Thankyou = () => {
    const history = useHistory();
    const handleReturnHome = () => {
        history.push('/');
    };
    return (
        <div className="container">
            <div className={styles.thankYouContainer}>
                <div className={styles.thankYouBox}>
                    <div className={styles.imageThankYou}>
                        <span
                            className={`material-symbols-outlined ${
                                styles.iconSuccess
                            }`}
                        >
                            check_circle
                        </span>
                        <p className={styles.textSuccess}>Payment Success</p>
                    </div>
                    <div className={styles.numberOrder}>
                        <p className={`${styles.textNumber}`}>
                            Your order number is{' '}
                        </p>
                        <p className={`${styles.textNumber} ${styles.id}`}>
                            #2209270001550
                        </p>
                    </div>
                    <div className={styles.contentThankYou}>
                        <p className={styles.text}>
                            Thank you for placing an order with Nuresmarketplace
                            You can view details of your order by clicking here.
                        </p>
                        <p className={styles.text}>
                            If you have questions about your order, you can send
                            an e-mail to{' '}
                            <span>help_me_please@nursemarketplace.com .</span>
                        </p>
                    </div>
                    <div className={styles.buttonThankYou}>
                        <button
                            className={styles.btn}
                            onClick={handleReturnHome}
                        >
                            Return Home
                        </button>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Thankyou;
