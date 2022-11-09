import { useQuery } from '@apollo/react-hooks';
import { DEFAULT_CATEGORY_ID, DEFAULT_BANNER } from '../../config';
import GET_CATEGORY from './getCategory.graphql';
import GET_BANNER from './getBanner.graphql';
import GET_PRODUCT from './getProduct.graphql';

export const useHome = ({ pageSize }) => {
  const {
    data: dataCategory,
    loading: loadingCategory,
    error: errorCategory
  } = useQuery(GET_CATEGORY, {
    variables: {
      id: DEFAULT_CATEGORY_ID
    }
  });

  const {
    data: dataBanner,
    loading: loadingBanner,
    error: errorBanner
  } = useQuery(GET_BANNER, {
    variables: {
      identifiers: DEFAULT_BANNER
    }
  });

  const {
    data: dataFlashSaleProduct,
    loading: loadingFlashSaleProduct,
    error: errorFlashSaleProduct
  } = useQuery(GET_PRODUCT, {
    variables: {
      search: 'toy',
      pageSize: 20,
      currentPage: 1,
      filter: {},
      sort: {}
    }
  });

  const {
    data: dataHotDealProduct,
    loading: loadingHotDealProduct,
    error: errorHotDealProduct
  } = useQuery(GET_PRODUCT, {
    variables: {
      search: 'toy',
      pageSize: 20,
      currentPage: 1,
      filter: {},
      sort: {}
    }
  });

  const {
    data: dataBestSellerProduct,
    loading: loadingBestSellerProduct,
    error: errorBestSellerProduct
  } = useQuery(GET_PRODUCT, {
    variables: {
      search: 'toy',
      pageSize: 20,
      currentPage: 1,
      filter: {},
      sort: {}
    }
  });

  const {
    data: dataAllProduct,
    loading: loadingAllProduct,
    error: errorAllProduct
  } = useQuery(GET_PRODUCT, {
    variables: {
      search: '',
      pageSize: pageSize,
      currentPage: 1,
      filter: {},
      sort: {}
    }
  });

  return {
    // Data and items of category
    category: dataCategory || undefined,
    loadingCategory,
    errorCategory,
    // Data and items of Banner
    banner: dataBanner || undefined,
    loadingBanner,
    errorBanner,
    // Data and items of Flash sale product
    flashSaleProduct: dataFlashSaleProduct || undefined,
    loadingFlashSaleProduct,
    errorFlashSaleProduct,
    // Data and items of Hot deal product
    hotDealProduct: dataHotDealProduct || undefined,
    loadingHotDealProduct,
    errorHotDealProduct,
    // Data and items of Best seller product
    bestSellerProduct: dataBestSellerProduct || undefined,
    loadingBestSellerProduct,
    errorBestSellerProduct,
    // Data and items of All product
    allProduct: dataAllProduct || undefined,
    loadingAllProduct,
    errorAllProduct
  };
};
