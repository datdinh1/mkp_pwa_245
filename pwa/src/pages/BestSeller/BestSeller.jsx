import React, { useEffect } from 'react';
import Banner from '../../components/Banner/banner';
import BannerAdvertise from '../../components/BannerAdvertise';
import ListProduct from '../../components/ListProduct';
import MainCategory from '../../components/MainCategory';
import styles from './bestSeller.module.scss';

const BestSellerLanding = () => {
  useEffect(() => {
    window.scrollTo(0, 0);
  }, []);
  return (
    <div className={styles.bestSellerContainer}>
      <div className="container">
        <section className={styles.bestSellerBanner}>
          <Banner dots={true} data={undefined} />
        </section>
        <section className={styles.bestSellerListProduct}>
          <ListProduct
            typeTitle="text"
            title="Recommend Product"
            isSlider={true}
          />
        </section>
        <section className={styles.bestSellerBannerAdvertise}>
          <BannerAdvertise />
        </section>
        <section className={styles.bestSellerMainCategory}>
          <MainCategory />
        </section>
        <section className={styles.bestSellerListProduct}>
          <ListProduct
            typeTitle="text"
            isSlider={false}
            isButton={true}
            title="Best Seller"
            isThroughTitle={true}
          />
        </section>
      </div>
    </div>
  );
};

export default BestSellerLanding;
