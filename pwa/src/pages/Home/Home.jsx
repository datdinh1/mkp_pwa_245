import React, { useEffect } from 'react';
import { useState } from 'react';
import Banner from '../../components/Banner/banner';
import BannerAdvertise from '../../components/BannerAdvertise';
import ListAdvertise from '../../components/ListAdvertise/listAdvertise';
import ListMenu from '../../components/ListMenu';
import ListProduct from '../../components/ListProduct/listProduct';
import Table from '../../components/Table';
import styles from './home.module.scss';
import { useHome } from './useHome';

const HomePage = () => {
  const [pageSize, setPageSize] = useState(10);
  const data = useHome({
    pageSize
  });

  const {
    category,
    banner,
    bestSellerProduct,
    allProduct,
    loadingAllProduct,
    flashSaleProduct,
    hotDealProduct
  } = data;

  useEffect(() => {
    window.scrollTo(0, 0);
  }, []);

  return (
    <div className={styles.homeContainer}>
      <div className="container">
        {/* BANNER */}
        {banner
          ? banner.cmsBlocks.items.length > 0 && (
              <section className={styles.homeBanner}>
                <Banner data={banner.cmsBlocks} dots={true} />
              </section>
            )
          : ''}
        <section className={styles.homeListMenu}>
          <ListMenu />
        </section>
        <section className={styles.homeListAdvertise}>
          <ListAdvertise />
        </section>
        {/* CATEGORY */}
        {category
          ? category.category.children.length > 0 && (
              <section className={styles.homeTable}>
                <Table data={category.category} />
              </section>
            )
          : ''}
        {flashSaleProduct
          ? flashSaleProduct.products.items.length > 0 && (
              <section className={styles.homeListProduct}>
                <ListProduct
                  title="Flash Sale"
                  link="/flash-sale"
                  typeTitle="text"
                  isSlider={true}
                  data={flashSaleProduct.products.items}
                />
              </section>
            )
          : ''}

        <section className={styles.bannerAdvertise}>
          <BannerAdvertise />
        </section>
        {hotDealProduct
          ? hotDealProduct.products.items.length > 0 && (
              <section className={styles.homeListProduct}>
                <ListProduct
                  title="Hot Deal"
                  link="/hot-deal"
                  typeTitle="text"
                  isSlider={true}
                  data={hotDealProduct.products.items}
                />
              </section>
            )
          : ''}
        <section className={styles.bannerAdvertise}>
          <BannerAdvertise />
        </section>
        {bestSellerProduct
          ? bestSellerProduct.products.items.length > 0 && (
              <section className={styles.homeListProduct}>
                <ListProduct
                  title="Best Seller"
                  link="/best-seller"
                  typeTitle="text"
                  isSlider={true}
                  data={bestSellerProduct.products.items}
                />
              </section>
            )
          : ''}
        <section className={styles.bannerAdvertise}>
          <BannerAdvertise />
        </section>
        {allProduct
          ? allProduct.products.items.length > 0 && (
              <section className={styles.homeListProduct}>
                <ListProduct
                  title="All product"
                  link="/all-product"
                  typeTitle="text"
                  isButton={true}
                  isSlider={false}
                  data={allProduct.products.items}
                  changePageSize={setPageSize}
                  isLoading={loadingAllProduct}
                />
              </section>
            )
          : ''}
      </div>
    </div>
  );
};

export default HomePage;
