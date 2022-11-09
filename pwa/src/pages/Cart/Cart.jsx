import React, { useCallback, useEffect, useState } from 'react';
import CartCheckout from '../../components/CartCheckout';
import ListProductCart from '../../components/listProductCart/listProductCart';
import styles from './cart.module.scss';

const dataProduct = [
    {
        shop: { id: 'shop-1', name: 'wiki1' },
        product: [
            {
                id: 'product-1',
                name: 'product 1',
                price: '300THB',
                id_product: 'shop-1'
            },

            {
                id: 'product-3',
                name: 'product 3',
                price: '300THB',
                id_product: 'shop-1'
            },
            {
                id: 'product-4',
                name: 'product 4',
                price: '300THB',
                id_product: 'shop-1'
            },

            {
                id: 'product-6',
                name: 'product 6',
                price: '300THB',
                id_product: 'shop-1'
            }
        ]
    },
    {
        shop: { id: 'shop-2', name: 'wiki2' },
        product: [
            {
                id: 'product-7',
                name: 'product 7',
                price: '300THB',
                id_product: 'shop-2'
            },
            {
                id: 'product-9',
                name: 'product 9',
                price: '300THB',
                id_product: 'shop-2'
            },
            {
                id: 'product-11',
                name: 'product 11',
                price: '300THB',
                id_product: 'shop-2'
            }
        ]
    },
    {
        shop: { id: 'shop-3', name: 'wiki3' },
        product: [
            {
                id: 'product-5',
                name: 'product 5',
                price: '300THB',
                id_product: 'shop-3'
            },
            {
                id: 'product-8',
                name: 'product 8',
                price: '300THB',
                id_product: 'shop-3'
            },
            {
                id: 'product-2',
                name: 'product 2',
                price: '300THB',
                id_product: 'shop-3'
            }
        ]
    }
];

const Cart = () => {
    const [listProductChecked, setListProductChecked] = useState([]);

    const handleCheckProduct = useCallback(
        ({ data, e, type }) => {
            switch (type) {
                case 'ALL':
                    if (e.target.checked) {
                        setListProductChecked(data);
                    } else {
                        setListProductChecked(
                            listProductChecked.filter(
                                val => !data.includes(val)
                            )
                        );
                    }

                    break;
                case 'ARRAY':
                    if (e.target.checked) {
                        const a = listProductChecked.concat(data);
                        setListProductChecked(
                            a.filter((item, index) => a.indexOf(item) === index)
                        );
                    } else {
                        setListProductChecked(
                            listProductChecked.filter(
                                val => !data.includes(val)
                            )
                        );
                    }
                    break;
                case 'SINGLE':
                    if (e.target.checked) {
                        setListProductChecked([...listProductChecked, data]);
                    } else {
                        setListProductChecked(
                            listProductChecked.filter(
                                (item, index) => item !== data
                            )
                        );
                    }
                    break;
                default:
                    break;
            }
        },
        [listProductChecked]
    );

    useEffect(() => {
        window.scrollTo(0, 0);
    }, []);

    return (
        <div className="container">
            <div className={styles.cartContainer}>
                {dataProduct && (
                    <section className={styles.cartLeft}>
                        <ListProductCart
                            listProductChecked={listProductChecked}
                            data={dataProduct}
                            handleCheckProduct={handleCheckProduct}
                        />
                    </section>
                )}

                <section className={styles.cartRight}>
                    <CartCheckout
                        data={dataProduct}
                        handleCheckProduct={handleCheckProduct}
                        listProductChecked={listProductChecked}
                    />
                </section>
            </div>
        </div>
    );
};

export default Cart;
