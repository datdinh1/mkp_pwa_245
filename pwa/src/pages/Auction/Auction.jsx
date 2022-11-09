import React from 'react';
import Banner from '../../components/Banner/banner';
import styles from './auction.module.scss';
import { useAution } from './useAution';
import GET_BANNER from '../Home/getBanner.graphql';
import GET_PRODUCT from '../Home/getProduct.graphql';
import ListProduct from '../../components/ListProduct/listProduct';
import ListMenu from '../../components/ListMenu/listMenu';

const Auction = () => {
  const talonProps = useAution({
    getBanner: GET_BANNER,
    getProduct: GET_PRODUCT
  });

  const {
    banner,
    loadingBanner,
    auctionProduct,
    loadingAuctionProduct
  } = talonProps;
  return (
    <div className="container">
      {!loadingBanner && banner && banner.cmsBlocks.items.length > 0 && (
        <section className={styles.auctionBanner}>
          <Banner data={banner.cmsBlocks} dots={true} />
        </section>
      )}
      <section className={styles.auctionMenu}>
        <ListMenu />
      </section>
      {!loadingAuctionProduct &&
        auctionProduct &&
        auctionProduct.products.items.length > 0 && (
          <section className={styles.autionProductList}>
            <ListProduct
              title="All Products"
              data={auctionProduct.products.items}
              typeTitle="text"
              isAuction={true}
            />
          </section>
        )}
    </div>
  );
};

export default Auction;
