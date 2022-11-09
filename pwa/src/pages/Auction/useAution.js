import { DEFAULT_BANNER } from '../../config';
import { useQuery } from '@apollo/react-hooks';

export const useAution = ({ getBanner, getProduct }) => {
  const {
    data: dataBanner,
    loading: loadingBanner,
    error: errorBanner
  } = useQuery(getBanner, {
    variables: {
      identifiers: DEFAULT_BANNER
    }
  });

  const {
    data: dataAuctionProduct,
    loading: loadingAuctionProduct,
    error: errorAuctionProduct
  } = useQuery(getProduct, {
    variables: {
      search: 'toy',
      pageSize: 20,
      currentPage: 1,
      filter: {},
      sort: {}
    }
  });

  return {
    // Data and items of Banner
    banner: dataBanner || undefined,
    loadingBanner,
    errorBanner,
    // Data and items of Auction Product
    auctionProduct: dataAuctionProduct || undefined,
    loadingAuctionProduct,
    errorAuctionProduct
  };
};
