import React, { memo } from 'react';
import {
    Heart as HeartIcon,
    MinusCircle as MinusCircleIcon,
    PlusCircle as PlusCircleIcon,
    Trash as TrashIcon
} from 'react-feather';
import CheckboxInput from '../CheckboxInput/checkboxInput';
import styles from './listProductCart.module.scss';

const ListProductCart = ({ data, handleCheckProduct, listProductChecked }) => {
    return (
        <div className={styles.ListProductCartContainer}>
            {data.map((item, index) => (
                <div className={styles.ListProductCartBox} key={index}>
                    <div className={styles.boxHeader}>
                        <div className={styles.infoShop}>
                            <div className={styles.checkBox}>
                                <CheckboxInput
                                    handleCheck={handleCheckProduct}
                                    isChecked={
                                        item.product.filter(val =>
                                            listProductChecked.includes(val.id)
                                        ).length === item.product.length
                                            ? true
                                            : false
                                    }
                                    type="ARRAY"
                                    id={item.product.map(item => item.id)}
                                />
                            </div>
                            <div className={styles.nameShop}>
                                <span
                                    className={`material-symbols-outlined ${
                                        styles.storeIcon
                                    }`}
                                >
                                    storefront
                                </span>
                                <h3 className={styles.nameText}>
                                    {item.shop.name}
                                </h3>
                            </div>
                        </div>
                        <div className={styles.discountCode}>
                            <h5 className={styles.codeText}>
                                Choose a discount code
                            </h5>
                        </div>
                    </div>
                    <div className={styles.boxListProduct}>
                        {item.product.map((product, index) => (
                            <div className={styles.productItem} key={index}>
                                <div className={styles.left}>
                                    <div className={styles.checkBox}>
                                        <CheckboxInput
                                            handleCheck={handleCheckProduct}
                                            isChecked={
                                                listProductChecked.find(
                                                    checked =>
                                                        checked === product.id
                                                )
                                                    ? true
                                                    : false
                                            }
                                            type="SINGLE"
                                            id={product.id}
                                        />
                                    </div>
                                    <div className={styles.productImage}>
                                        <img
                                            className={styles.productImg}
                                            src="https://media.istockphoto.com/photos/table-top-view-of-spicy-food-picture-id1316145932?b=1&k=20&m=1316145932&s=170667a&w=0&h=feyrNSTglzksHoEDSsnrG47UoY_XX4PtayUPpSMunQI="
                                            alt=""
                                        />
                                    </div>
                                </div>
                                <div className={styles.right}>
                                    <div className={styles.rightTop}>
                                        <div className={styles.nameProduct}>
                                            <h4 className={styles.nameText}>
                                                {product.name}
                                            </h4>
                                        </div>
                                        <div className={styles.priceProduct}>
                                            <h4 className={styles.priceText}>
                                                {product.price}
                                            </h4>
                                        </div>
                                        <div className={styles.quantityBox}>
                                            <button
                                                type="button"
                                                // onClick={() => handleSetQuantity(quantity - 1)}
                                                // disabled={quantity <= 1 && true}
                                            >
                                                <MinusCircleIcon
                                                    className={
                                                        styles.quantityIcon
                                                    }
                                                />
                                            </button>
                                            <span
                                                className={styles.quantityText}
                                            >
                                                1
                                            </span>
                                            <button
                                                type="button"
                                                // onClick={() => handleSetQuantity(quantity + 1)}
                                            >
                                                <PlusCircleIcon
                                                    className={
                                                        styles.quantityIcon
                                                    }
                                                />
                                            </button>
                                        </div>
                                    </div>
                                    <div className={styles.rightBottom}>
                                        <button
                                            className={`${styles.button} ${
                                                styles.love
                                            }`}
                                        >
                                            <i>
                                                <HeartIcon
                                                    className={
                                                        styles.iconButton
                                                    }
                                                />
                                            </i>{' '}
                                            | Interested products
                                        </button>
                                        <button className={`${styles.button}`}>
                                            <TrashIcon
                                                className={styles.iconButton}
                                            />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            ))}
        </div>
    );
};

export default memo(ListProductCart);
