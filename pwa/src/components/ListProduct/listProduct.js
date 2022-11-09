import React, { useEffect, useState } from 'react';
import {
  ChevronLeft as LeftArrowIcon,
  ChevronRight as RightArrowIcon
} from 'react-feather';
import { Link } from 'react-router-dom';
import Slider from 'react-slick';
import styles from './listProduct.module.scss';
import btnLoading from 'src/styles/images/btnLoading.svg';

function SampleNextArrow(props) {
  const { onClick } = props;
  return (
    <div className={styles.nextArrow} onClick={onClick}>
      <LeftArrowIcon className={styles.arrowIcon} />
      <div className={styles.backgroundArrow} />
    </div>
  );
}

function SamplePrevArrow(props) {
  const { onClick } = props;
  return (
    <div className={styles.prevArrow} onClick={onClick}>
      <RightArrowIcon className={styles.arrowIcon} />
      <div className={styles.backgroundArrow} />
    </div>
  );
}

const PriceNormal = ({ item }) => {
  return (
    <>
      <div className={styles.productItemPrice}>
        {item.price_range.minimum_price.discount.amount_off > 0 && (
          <div className={styles.productPriceSale}>
            <h3>
              {item.price_range.minimum_price.regular_price.currency}{' '}
              {item.price_range.minimum_price.final_price.value}
            </h3>
          </div>
        )}
        <div
          className={`${styles.productItemCost} ${item.price_range.minimum_price
            .discount.amount_off > 0 && styles.productItemCostSale}`}
        >
          <h3>
            {item.price_range.minimum_price.regular_price.currency}{' '}
            {item.price_range.minimum_price.regular_price.value}
          </h3>
        </div>
      </div>
    </>
  );
};

const PriceAuction = ({ item }) => {
  return (
    <div className={styles.PriceContainer}>
      <div className={styles.top}>
        <div className={styles.time}>
          <p className={styles.timeText}>1:</p>
          <p className={styles.timeText}>20:</p>
          <p className={styles.timeText}>60</p>
        </div>
        <div className={styles.price}>
          <h3 className={styles.priceText}>THB 200</h3>
        </div>
      </div>
      <div className={styles.bottom}>
        <Link to={`${item.url_key}.html`} className={styles.bid}>
          Bid now
        </Link>
      </div>
    </div>
  );
};

const NotSold = ({ item }) => {
  return (
    <div className={styles.PriceContainer}>
      <div className={`${styles.top} ${styles.disabled}`}>
        <div className={styles.status}>
          <h3 className={styles.statusText}>about to open an auction</h3>
        </div>
      </div>
      <div className={styles.bottom}>
        <Link to={'#'} className={`${styles.bid} ${styles.disabled}`}>
          Bid now
        </Link>
      </div>
    </div>
  );
};

const ListProduct = ({
  title,
  typeTitle,
  isButton,
  isSlider,
  isThroughTitle,
  link,
  data,
  changePageSize,
  isLoading,
  isAuction
}) => {
  const [isSwitch, setIsSwitch] = useState(true);

  const settings = {
    infinite: true,
    speed: 500,
    slidesToShow: 5,
    slidesToScroll: 5,
    nextArrow: <SamplePrevArrow />,
    prevArrow: <SampleNextArrow />,
    beforeChange: () => setIsSwitch(false),
    afterChange: () => setIsSwitch(true),
    responsive: [
      {
        breakpoint: 1281,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 3
        }
      },
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 5,
          slidesToScroll: 5
        }
      },
      {
        breakpoint: 912,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 4
        }
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 4
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      }
    ]
  };

  const [screen, setScreen] = useState(window.screen.width);

  const numberProductSlice =
    screen > 1281
      ? 5
      : screen > 1024
      ? 4
      : screen > 912
      ? 5
      : screen > 768
      ? 4
      : screen > 600
      ? 4
      : screen > 600
      ? 4
      : 2;

  useEffect(() => {
    const responsive = () => {
      setScreen(window.screen.width);
    };

    window.addEventListener('resize', responsive);
    return () => {
      window.removeEventListener('resize', responsive);
    };
  }, [window.screen.width]);

  return data ? (
    <div className={styles.listProductContainer}>
      {isThroughTitle === true ? (
        <div className={`${styles.listProductHeader} ${styles.headerThrough}`}>
          <div className={`${styles.listProductTitle} ${styles.titleThrough}`}>
            <h1 className={`${styles.listProductText}`}>{title}</h1>
          </div>
          <h5 className={`${styles.listProductMiniTitle}`}>New Product</h5>
          <div className={`${styles.listProductDivider}`} />
        </div>
      ) : (
        // HEADER OF LIST PRODUCT
        <div className={styles.listProductHeader}>
          <div className={styles.listProductTitle}>
            {typeTitle === 'img' ? (
              <img
                className={styles.listProductImage}
                src=""
                alt=""
                loading="lazy"
              />
            ) : (
              <h1 className={styles.listProductText}>{title}</h1>
            )}
          </div>
          {link && (
            <div className={styles.listProductLink}>
              <Link to={link}>
                See more <RightArrowIcon className={styles.iconLink} />
              </Link>
            </div>
          )}
        </div>
      )}

      {/* LIST PRODUCT */}
      {isSlider === true ? (
        // CASE SLIDER
        <div className={`${styles.listProductItem}`}>
          <Slider {...settings}>
            {data.map((item, index) => (
              <div className={styles.productBox} key={index}>
                {/* ITEM PRODUCT */}
                <div className={styles.productItem}>
                  <Link to={isSwitch ? `${item.url_key}.html` : '#'}>
                    <div className={styles.productItemImage}>
                      <img
                        className={styles.productItemImg}
                        src={item.image.url}
                        alt=""
                        loading="lazy"
                      />
                      {/* <div className={styles.productItemTag}>
                        <p>new product</p>
                      </div> */}
                    </div>
                    <div className={styles.productItemTitle}>
                      <h4>{item.name}</h4>
                    </div>
                    <PriceNormal item={item} />
                  </Link>
                </div>
              </div>
            ))}
            {data.length < numberProductSlice &&
              Array(numberProductSlice - data.length)
                .fill(0)
                .map((item, index) => (
                  <span key={index} style={{ display: 'none' }} />
                ))}
          </Slider>
        </div>
      ) : (
        // CASE NO SLIDER
        <div className={`${styles.listProductItemNoSlider}`}>
          {data.map((item, index) => (
            // ITEM PRODUCT
            <Link to={`${item.url_key}.html`} key={index}>
              <div
                className={`${styles.productItem} ${
                  styles.productItemNoSlider
                }`}
              >
                <div className={styles.productItemImage}>
                  <img
                    className={styles.productItemImg}
                    src={item.image.url}
                    alt=""
                    loading="lazy"
                  />
                  {/* <div className={styles.productItemTag}>
                    <p>new product</p>
                  </div> */}
                </div>
                <div className={styles.productItemTitle}>
                  <h4>{item.name}</h4>
                </div>
                {!isAuction ? (
                  <PriceNormal item={item} />
                ) : Number.isInteger(index / 2) ? (
                  <PriceAuction item={item} />
                ) : (
                  <NotSold item={item} />
                )}
              </div>
            </Link>
          ))}
        </div>
      )}

      {isButton === true && data.length < 20 && (
        //BUTTON SHOW MORE
        <div className={styles.buttonContainer}>
          <button
            disabled={isLoading && true}
            className={styles.buttonShowMore}
            onClick={() => changePageSize(20)}
          >
            {isLoading === true && (
              <img className="mr-3" width={15} src={btnLoading} alt="loading" />
            )}
            Show more
          </button>
        </div>
      )}
    </div>
  ) : (
    <></>
  );
};

export default ListProduct;
