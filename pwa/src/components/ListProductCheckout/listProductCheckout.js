import React from 'react';
import styles from './listProductCheckout.module.scss';
import SHIPPING_METHOD from 'src/styles/images/shipping_method.png';
import ShippingMethodPopup from './ShippingMethodPopup/shippingMethodPopup';
import { useAppContext } from '@magento/peregrine/lib/context/app';

const ListProductCheckout = () => {
    const [, { toggleDrawer }] = useAppContext();
    return (
        <div className={styles.listProductCheckoutContainer}>
            {Array(2)
                .fill(0)
                .map((item, index) => (
                    <div className={styles.listProductCheckoutBox} key={index}>
                        <div className={styles.boxHeader}>
                            <span
                                className={`material-symbols-outlined ${
                                    styles.storeIcon
                                }`}
                            >
                                storefront
                            </span>
                            <h3 className={styles.titleText}>Shop wiki1</h3>
                        </div>
                        <div className={styles.boxBody}>
                            <div className={styles.bodyLeft}>
                                <div className={styles.listProduct}>
                                    {Array(4)
                                        .fill(0)
                                        .map((item, index) => (
                                            <div
                                                className={styles.productItem}
                                                key={index}
                                            >
                                                <div
                                                    className={
                                                        styles.productImage
                                                    }
                                                >
                                                    <img
                                                        src="https://images.immediate.co.uk/production/volatile/sites/30/2013/05/One-pan-spaghetti-f2aca14.jpg?quality=90&resize=556,505"
                                                        alt=""
                                                        className={
                                                            styles.imgProduct
                                                        }
                                                    />
                                                </div>
                                                <div
                                                    className={
                                                        styles.inforProduct
                                                    }
                                                >
                                                    <div
                                                        className={
                                                            styles.nameProduct
                                                        }
                                                    >
                                                        <h3
                                                            className={
                                                                styles.nameText
                                                            }
                                                        >
                                                            Preorder
                                                        </h3>
                                                    </div>
                                                    <div
                                                        className={
                                                            styles.priceProduct
                                                        }
                                                    >
                                                        <h3
                                                            className={
                                                                styles.priceText
                                                            }
                                                        >
                                                            THB25,000
                                                        </h3>
                                                        <h3
                                                            className={
                                                                styles.quantityText
                                                            }
                                                        >
                                                            x2
                                                        </h3>
                                                    </div>
                                                </div>
                                            </div>
                                        ))}
                                </div>
                            </div>

                            <div className={styles.bodyRight}>
                                <div className={styles.shippingMethod}>
                                    <h6
                                        className={styles.shippingMethodText}
                                        onClick={() =>
                                            toggleDrawer('shipping-method')
                                        }
                                    >
                                        Choose Shipping Method
                                    </h6>
                                </div>
                                <div className={styles.infoDelivery}>
                                    <div className={styles.left}>
                                        <p className={styles.deliveryText}>
                                            delivered by
                                        </p>
                                        <img
                                            src={SHIPPING_METHOD}
                                            alt="shipping"
                                            className={styles.imgShipping}
                                        />
                                    </div>
                                    <div className={styles.right}>
                                        <h6 className={styles.priceText}>
                                            20THB
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className={styles.boxFooter}>
                            <div className={styles.infoPayment}>
                                <p className={styles.priceInfo}>Total</p>
                                <p className={styles.priceInfo}>฿15,491</p>
                            </div>
                            <div className={styles.infoPayment}>
                                <p className={styles.priceInfo}>Discount</p>
                                <p className={styles.priceInfo}>฿0</p>
                            </div>
                            <div className={styles.infoPayment}>
                                <p className={styles.priceInfo}>
                                    Shipping cost
                                </p>
                                <p className={styles.priceInfo}>฿5</p>
                            </div>
                            <div className={styles.infoPayment}>
                                <p
                                    className={`${styles.priceInfo} ${
                                        styles.total
                                    }`}
                                >
                                    Total price
                                </p>
                                <p
                                    className={`${styles.priceInfo}  ${
                                        styles.total
                                    }`}
                                >
                                    ฿15,496
                                </p>
                            </div>
                        </div>
                    </div>
                ))}

            <ShippingMethodPopup />
        </div>
    );
};

export default ListProductCheckout;
