import React, { Fragment, useEffect } from 'react';
import { useProduct } from '@magento/peregrine/lib/talons/RootComponents/Product/useProduct';
import { Title, Meta } from '@magento/venia-ui/lib/components/Head';
import { fullPageLoadingIndicator } from '@magento/venia-ui/lib/components/LoadingIndicator';
import { MagentoGraphQLTypes } from '@magento/venia-ui/lib/util/apolloCache';
import getUrlKey from '@magento/venia-ui/lib/util/getUrlKey';
import mapProduct from '@magento/venia-ui/lib/util/mapProduct';
import GET_PRODUCT_DETAIL from '@magento/venia-ui/lib/queries/getProductDetail.graphql';
import PRODUCT_DETAILS_FRAGMENT from '@magento/venia-ui/lib/fragments/productDetails.graphql';

import ProductFullDetail from 'src/components/ProductFullDetail';

const Product = () => {
  useEffect(() => {
    window.scrollTo(0, 0);
  }, []);

  const talonProps = useProduct({
    cachePrefix: MagentoGraphQLTypes.ProductInterface,
    fragment: PRODUCT_DETAILS_FRAGMENT,
    mapProduct,
    query: GET_PRODUCT_DETAIL,
    urlKey: getUrlKey()
  });

  const { error, loading, product } = talonProps;

  if (loading && !product) return fullPageLoadingIndicator;
  if (error) return <div>Data Fetch Error</div>;

  if (!product) {
    return (
      <h1>This Product is currently out of stock. Please try again later.</h1>
    );
  }

  // Note: STORE_NAME is injected by Webpack at build time.

  return (
    <Fragment>
      <Title>{`${product.name} - ${STORE_NAME}`}</Title>
      <Meta name="description" content={product.meta_description} />
      <div className="container">
        <ProductFullDetail product={product} />
      </div>
    </Fragment>
  );
};

export default Product;
