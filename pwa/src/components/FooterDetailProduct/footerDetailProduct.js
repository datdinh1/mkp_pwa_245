import React from 'react';
import {
  MessageSquare as MessageIcon,
  ShoppingCart as CartIcon
} from 'react-feather';
import { Link } from 'react-router-dom';
import styles from './footerDetailProduct.module.scss';

const FooterDetailProduct = () => {
  return (
    <div className={styles.toggleMobbileContainer}>
      <ul className={styles.menuList}>
        <li className={styles.menuItem}>
          <Link
            to="/"
            style={{ borderRight: '1px solid grey', paddingRight: '12px' }}
          >
            <i>
              <MessageIcon className={` ${styles.menuIcon}`} />
            </i>
            Chat now
          </Link>
          <i />
        </li>
        <li className={styles.menuItem}>
          <p>
            <i>
              <CartIcon className={` ${styles.menuIcon}`} />
            </i>
            Add to cart
          </p>
          <i />
        </li>
        <li className={styles.menuItem}>
          <button className={styles.buttonBuy}>Buy now</button>
        </li>
      </ul>
    </div>
  );
};

export default FooterDetailProduct;
