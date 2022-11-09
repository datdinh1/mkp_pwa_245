import React from 'react';
import { NavLink } from 'react-router-dom';
import styles from './headerStore.module.scss';
import { useTranslation } from 'react-i18next';
import FOLLOW from '../../styles/images/follow.png';
import CHAT from '../../styles/images/chat.png';
import RATING from '../../styles/images/rating.png';

const HeaderStore = () => {
  const { t } = useTranslation(['profile']);

  return (
    <header className={styles.headerContainer}>
      <div className={styles.coverImage}>
        <img
          src="https://timelinecovers.pro/facebook-cover/download/photography-city-lights-facebook-cover.jpg"
          alt="cover image"
          loading="lazy"
          className={styles.coverImg}
        />
      </div>
      <div className="container">
        <div className={styles.headerBody}>
          <div className={styles.left}>
            <div className={styles.avatar}>
              <img
                src="https://img.freepik.com/free-vector/cartoon-style-cafe-front-shop-view_134830-697.jpg?w=2000"
                alt="avatar"
                loading="lazy"
                className={styles.avatarImg}
              />
            </div>
            <div className={styles.infoShop}>
              <div className={styles.nameShop}>
                <h3 className={styles.nameShopText}>Shop wiki1</h3>
              </div>
              <ul className={styles.listInfo}>
                <li className={styles.inforItem}>
                  <img src={FOLLOW} alt="" className={styles.infoIcon} />
                  <span className={styles.infoText}>{t('Follower')}</span>
                </li>
                <li className={styles.inforItem}>
                  <img src={RATING} alt="" className={styles.infoIcon} />
                  <span className={styles.infoText}>{t('Store Rating')}</span>
                </li>
                <li className={styles.inforItem}>
                  <img src={CHAT} alt="" className={styles.infoIcon} />
                  <span className={styles.infoText}>
                    {t('Very Fast Reply')}
                  </span>
                </li>
              </ul>
            </div>
          </div>

          <div className={styles.buttonGroup}>
            <button className={styles.toolButton}>
              {t('Follow The Store')}
            </button>
            <button className={styles.toolButton}>{t('Chat')}</button>
            <button className={styles.toolButton}>{t('Shop Profile')}</button>
          </div>
        </div>
        <ul className={styles.menuList}>
          <li className={styles.menuItem}>
            <NavLink
              to="/"
              className={styles.menuLink}
              activeClassName={styles.active}
            >
              {t('Home Page')}
            </NavLink>
          </li>
          <li className={styles.menuItem}>
            <NavLink
              to="/"
              className={styles.menuLink}
              activeClassName={styles.active}
            >
              {t('All Products')}
            </NavLink>
          </li>
          <li className={styles.menuItem}>
            <NavLink
              to="/"
              className={styles.menuLink}
              activeClassName={styles.active}
            >
              {t('Coupon')}
            </NavLink>
          </li>
        </ul>
      </div>
    </header>
  );
};

export default HeaderStore;
