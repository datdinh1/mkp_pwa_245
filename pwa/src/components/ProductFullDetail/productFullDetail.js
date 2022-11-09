import React from 'react';
import { useProductFullDetail } from '@magento/peregrine/lib/talons/ProductFullDetail/useProductFullDetail';
import ADD_CONFIGURABLE_MUTATION from '@magento/venia-ui/lib/queries/addConfigurableProductsToCart.graphql';
import ADD_SIMPLE_MUTATION from '@magento/venia-ui/lib/queries/addSimpleProductsToCart.graphql';
import CREATE_CART_MUTATION from '@magento/venia-ui/lib/queries/createCart.graphql';
import GET_CART_DETAILS_QUERY from '@magento/venia-ui/lib/queries/getCartDetails.graphql';
import InfoProduct from '../InfoProduct';
import DescriptionProduct from '../DescriptionProduct';
import ListProduct from '../ListProduct/listProduct';
import styles from './productFullDetail.module.scss';
import DataNull from '../DataNull/dataNull';
import ListCouponCollect from '../ListCouponCollect/listCouponCollect';
import InfoShop from '../InfoShop/infoShop';
import FooterDetailProduct from '../FooterDetailProduct/footerDetailProduct';

const ProductFullDetail = props => {
  const { product } = props;

  const talonPropsProductDetail = useProductFullDetail({
    addConfigurableProductToCartMutation: ADD_CONFIGURABLE_MUTATION,
    addSimpleProductToCartMutation: ADD_SIMPLE_MUTATION,
    createCartMutation: CREATE_CART_MUTATION,
    getCartDetailsQuery: GET_CART_DETAILS_QUERY,
    product
  });

  const {
    breadcrumbCategoryId,
    handleAddToCart,
    handleSelectionChange,
    handleSetQuantity,
    isAddToCartDisabled,
    mediaGalleryEntries,
    productDetails,
    quantity
  } = talonPropsProductDetail;

  return (
    <>
      <section className={styles.infoProductSection}>
        <InfoProduct
          data={productDetails}
          categoryId={breadcrumbCategoryId}
          listImage={mediaGalleryEntries}
          handleAddToCart={handleAddToCart}
          isAddToCartDisabled={isAddToCartDisabled}
          quantity={quantity}
          handleSetQuantity={handleSetQuantity}
          isAuction={true}
        />
      </section>
      <section className={styles.descSection}>
        <DescriptionProduct />
      </section>
      <section className={styles.infoShopSection}>
        <InfoShop />
      </section>
      <section className={styles.listCouponSection}>
        <ListCouponCollect
          title="Store discount code"
          isTitle={true}
          isCategory={false}
          isSeeMoreTop={true}
        />
      </section>
      <section className={styles.listProductSection}>
        {/* <ListProduct
          isSlider={true}
          isButton={false}
          link="/"
          title="Recommended products"
          typeTitle="text"
        /> */}
        <DataNull notice="Dont have product" />
      </section>
      <section className={styles.nullSection}>
        {/* <ListProduct
          isSlider={true}
          isButton={false}
          link="/"
          title="Recommended products"
          typeTitle="text"
        /> */}
        <DataNull notice="Dont have anything" />
      </section>
      <FooterDetailProduct />
    </>
  );
};

export default ProductFullDetail;
