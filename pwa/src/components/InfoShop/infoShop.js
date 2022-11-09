import React from 'react';
import styles from './infoShop.module.scss';
import AVATAR from '../../styles/images/avatar.jpg';
import { Link } from 'react-router-dom';

const InfoShop = () => {
  return (
    <div className={styles.infoShopContainer}>
      <div className={styles.top}>
        <div className={styles.avatar}>
          <img src={AVATAR} alt="avatar" className={styles.avatarImg} />
          <p className={styles.avatarName}>WikiShop1</p>
        </div>
        <button className={styles.buttonFollow}>Follow</button>
      </div>
      <div className={styles.mid}>
        <div className={styles.midItem}>
          <p className={styles.number}>100</p>
          <p className={styles.text}>All products</p>
        </div>
        <div className={styles.midItem}>
          <p className={styles.number}>100%</p>
          <p className={styles.text}>fast delivery</p>
        </div>
        <div className={styles.midItem}>
          <p className={styles.number}>100%</p>
          <p className={styles.text}>response</p>
        </div>
      </div>
      <div className={styles.bottom}>
        <Link to="/shop/SELLER74" className={styles.bottomButton}>
          Store
        </Link>
        <Link to="#" className={styles.bottomButton}>
          Chat
        </Link>
      </div>
    </div>
  );
};

export default InfoShop;
