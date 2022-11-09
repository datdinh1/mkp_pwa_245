import React from 'react';
import styles from './headerCart.module.scss';
import { ChevronLeft as LeftIcon, Trash2 as TrashIcon } from 'react-feather';
import { Link } from 'react-router-dom';
const headerCart = () => {
  return (
    <header className={styles.headerCartContainer}>
      <div className="container">
        <div className={styles.headerCartBox}>
          <div className={styles.headerLeft}>
            <Link to="/">
              <i>
                <LeftIcon className={styles.iconHeader} />
              </i>
            </Link>
          </div>
          <div className={styles.headerMiddle}>
            <h1 className={styles.headerTitle}>Shopping Cart (12)</h1>
          </div>
          <div className={styles.headerRight}>
            <i>
              <TrashIcon className={styles.iconHeader} />
            </i>
          </div>
        </div>
      </div>
    </header>
  );
};

export default headerCart;
