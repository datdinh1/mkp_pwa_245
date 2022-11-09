import React from 'react';
import { useTranslation } from 'react-i18next';
import styles from './listProductFavourite.module.scss';
import { Link } from 'react-router-dom';
import { Trash2 as TrashIcon } from 'react-feather';
import DataNull from '../DataNull';

const ListProductFavourite = () => {
  const { t } = useTranslation('favourite');
  const dataNull = false;
  return (
    <div className={styles.listProductContainer}>
      {/* TITLE */}
      <div className={styles.listProductTitle}>
        <h1 className={styles.listProductTitleText}>
          {t('Favourite Products')}
        </h1>
      </div>
      {/* WISH LIST */}
      <div className={styles.listProductWishList}>
        {/* TITLE OF WISH LIST */}
        <div className={styles.wishListTitle}>
          <h2 className={styles.wishListTitleText}>{t('Wish List')}</h2>
        </div>
        {/* LIST FAVOURITE PRODUCT */}
        {dataNull ? (
          <div className={styles.wishListNull}>
            <DataNull />
          </div>
        ) : (
          <div className={styles.wishListListProduct}>
            {Array(8)
              .fill(0)
              .map((item, index) => (
                <div className={styles.productItem} key={index}>
                  <div className={styles.itemLeft}>
                    <div className={styles.itemLeftCheck}>
                      <div className="check-box">
                        <input
                          className="check-box__input"
                          type="checkbox"
                          // checked={isChecked}
                          // onChange={() => setIsChecked(!isChecked)}
                        />
                        <label className="check-box__label" />
                      </div>
                    </div>
                    <div className={styles.itemLeftImage}>
                      <img
                        src="https://www.pngmart.com/files/7/IPhone-PNG-Background-Image.png"
                        alt="product"
                        className={styles.itemLeftImg}
                        loading="lazy"
                      />
                    </div>
                    <div className={styles.itemLeftInfo}>
                      <Link to="/detail-product/1" className={styles.infoName}>
                        Coconut EmpreNAME NAME 01 Name Coconut EmpreNAME NAME 01
                        Name
                      </Link>
                      <p className={styles.infoPrice}>
                        {`${t('Price')}:`}&nbsp;
                        <span>{`180 ${t('Baht')}`}</span>
                      </p>
                    </div>
                  </div>
                  <div className={styles.itemRight}>
                    <div className={styles.itemRightDelete}>
                      <i>
                        <TrashIcon className={styles.itemRightDeleteIcon} />
                      </i>
                    </div>
                  </div>
                </div>
              ))}
          </div>
        )}

        {/* BUTTON GROUP */}
        <div className={styles.wishListButtonGroup}>
          <button type="button" className={styles.wishListButton}>
            {t('Cancel All')}
          </button>
          <button type="button" className={styles.wishListButton}>
            {t('Select All')}
          </button>
          <button
            type="button"
            disabled={dataNull}
            className={styles.wishListButton}
          >{`${t('Add To Cart')} (0)`}</button>
        </div>
      </div>
    </div>
  );
};

export default ListProductFavourite;
