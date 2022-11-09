import React, { useCallback } from 'react';
import styles from './listCouponCollect.module.scss';
import CATEGORY from '../../styles/images/category.png';
import { useTranslation } from 'react-i18next';
import { Link } from '@magento/venia-drivers';
import { useUserContext } from 'src/layouts/context/user';
import { useAppContext } from '@magento/peregrine/lib/context/app';

const ListCouponCollect = ({ isCategory, isTitle, title, isSeeMoreTop }) => {
  const { t } = useTranslation('coupon');
  const [{ isSignedIn, currentUser }] = useUserContext();
  const [, { toggleDrawer }] = useAppContext();

  const handleOpenPopup = useCallback(
    type => {
      toggleDrawer(type);
    },
    [toggleDrawer]
  );

  return (
    <div className={styles.listCouponCollectContainer}>
      <div
        className={`${styles.listCouponCollectHeader} ${isSeeMoreTop &&
          styles.isSeeMoreTop}`}
      >
        {isTitle && (
          <div className={styles.listCouponCollectTitle}>
            <h1 className={styles.couponCollectTitleText}>{t(`${title}`)}</h1>
          </div>
        )}

        <div className={styles.listCouponCollectSeeMore}>
          <p className={styles.seemoreText}>See more</p>
        </div>
      </div>

      {isCategory && (
        <div className={styles.listCouponCollectCategory}>
          <div className={styles.categoryTitle}>
            <h5 className={styles.categoryTitleText}>Category</h5>
          </div>
          <div className={styles.categoryImage}>
            <img
              src={CATEGORY}
              alt="category"
              className={styles.categoryImg}
              loading="lazy"
            />
          </div>
        </div>
      )}

      <div className={styles.wishListItem}>
        {Array(4)
          .fill(0)
          .map((item, index) => (
            <div className={styles.item} key={index}>
              <div className={styles.itemTop}>
                <div className={styles.itemLeft}>
                  <div className={styles.itemLeftImage}>
                    <img
                      className={styles.itemLeftImg}
                      src="https://i0.wp.com/eltallerdehector.com/wp-content/uploads/2022/07/one-piece-luffy-png.png?resize=800%2C800&ssl=1"
                      alt=""
                      loading="lazy"
                    />
                  </div>
                  <p className={styles.itemLeftName}>Luffy Shop</p>
                </div>
                <div className={styles.itemRight}>
                  <div className={styles.itemRightConTent}>
                    <h5 className={styles.contentTitle}>ส่วนลด 10%</h5>
                    <p className={styles.contentMinimum}>{`${t(
                      'ขั้นตํ่าzz 1000'
                    )}`}</p>
                    <p className={styles.contentDate}>{`${t(
                      'Valid to date'
                    )}: 10-10-2022`}</p>
                  </div>
                </div>
              </div>
              <div className={styles.itemBottom}>
                {isSignedIn && currentUser ? (
                  <div className={styles.itemUse}>
                    <Link to="#" className={styles.linkUse}>
                      {t('Store Code')}
                    </Link>
                  </div>
                ) : (
                  <div className={styles.itemUse}>
                    <Link
                      to={'#'}
                      onClick={() => {
                        handleOpenPopup('sign-in');
                      }}
                      className={styles.linkUse}
                    >
                      {t('Store Code')}
                    </Link>
                  </div>
                )}
              </div>
            </div>
          ))}
      </div>
    </div>
  );
};

export default ListCouponCollect;
