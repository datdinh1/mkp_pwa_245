import { Price } from '@magento/peregrine';
import { useAppContext } from '@magento/peregrine/lib/context/app';
import { generateUrlFromContainerWidth } from '@magento/venia-ui/lib/util/images';
import React, { useCallback, useEffect, useRef, useState } from 'react';
import {
  AlertOctagon as ReportIcon,
  ChevronLeft as LeftIcon,
  ChevronRight as RightIcon,
  Heart as HeartIcon,
  MinusCircle as MinusCircleIcon,
  MoreHorizontal as MoreIcon,
  PlusCircle as PlusCircleIcon,
  Share2 as ShareIcon,
  Star as StarIcon,
  Smile as SmileIcon
} from 'react-feather';
import Slider from 'react-slick';
import Breadcrumbs from '../../../node_modules/@magento/venia-ui/lib/components/Breadcrumbs';
import RadioInput from '../RadioInput/radioInput';
import styles from './infoProduct.module.scss';

export const SampleNextArrow = props => {
  const { onClick } = props;
  return (
    <div className={styles.nextArrow} onClick={onClick}>
      <RightIcon className={styles.arrowIcon} />
      <div className={styles.backgroundArrow} />
    </div>
  );
};

export const SamplePrevArrow = props => {
  const { onClick } = props;
  return (
    <div className={styles.prevArrow} onClick={onClick}>
      <LeftIcon className={styles.arrowIcon} />
      <div className={styles.backgroundArrow} />
    </div>
  );
};

const InfoProductAuction = ({ toggleDrawer }) => {
  return (
    <>
      <div className={styles.top}>
        <div className={styles.nameProduct}>
          <h1 className={styles.nameText}>Test 1</h1>
        </div>
        <div className={styles.timeLeft}>
          <div className={styles.titleTimeLeft}>
            <h6 className={styles.titleText}>Time left</h6>
          </div>
          <div className={styles.timeCount}>
            <p className={styles.timeText}>16:</p>
            <p className={styles.timeText}>16:</p>
            <p className={styles.timeText}>16</p>
          </div>
        </div>
      </div>
      <div className={styles.middle}>
        <div className={styles.infoItem}>
          <div className={styles.infoContent}>
            <p className={styles.contentText}>
              Condition:<span>Used</span>
            </p>
          </div>
          <div className={styles.infoContent}>
            <p className={styles.contentText}>
              Auction start date / time:<span> 2022-09-07 00:00:00</span>
            </p>
          </div>
          <div className={styles.infoContent}>
            <p className={styles.contentText}>
              Auction end date: <span>2022-12-12 00:00:00</span>
            </p>
          </div>
        </div>
        <div className={`${styles.infoItem} ${styles.priceInfo}`}>
          <div className={styles.infoContent}>
            <p className={`${styles.contentText} ${styles.priceText}`}>
              Price now:<span>฿123</span>
            </p>
          </div>
          <div
            className={`${styles.infoContent} ${styles.people}`}
            onClick={() => toggleDrawer('count-people')}
          >
            <p className={styles.contentText}>
              <SmileIcon className={styles.iconPeople} /> Number of bidders:
              <span>0</span>
            </p>
          </div>
        </div>
      </div>
      {/* <div className={styles.bottom}>1</div> */}
    </>
  );
};

const InfoProductNormal = ({
  data,
  breadcrumbs,
  quantity,
  handleSetQuantity,
  handleAddToCart,
  isAddToCartDisabled
}) => {
  return (
    <>
      <div className={styles.infoProductBreadcrums}>{breadcrumbs}</div>
      <div className={styles.infoProductName}>
        <h1>{data.name}</h1>
        <div className={styles.rate}>
          <div className={styles.star}>
            <StarIcon className={styles.starIcon} />
            <StarIcon className={styles.starIcon} />
            <StarIcon className={styles.starIcon} />
            <StarIcon className={styles.starIcon} />
            <StarIcon className={styles.starIcon} />
            <span>{`(0)`} &nbsp;</span>
          </div>
          <div className={styles.sold}>
            <span>|&nbsp; Sold 0</span>
          </div>
        </div>
      </div>
      <div className={styles.infoProductPrice}>
        <Price currencyCode={data.price.currency} value={data.price.value} />
      </div>
      <div className={styles.infoProductQuantity}>
        <p className={styles.quantityTitle}>quantity</p>
        <div className={styles.quantityBox}>
          <button
            type="button"
            onClick={() => handleSetQuantity(quantity - 1)}
            disabled={quantity <= 1 && true}
          >
            <MinusCircleIcon className={styles.quantityIcon} />
          </button>
          <span className={styles.quantityText}>{quantity}</span>
          <button type="button" onClick={() => handleSetQuantity(quantity + 1)}>
            <PlusCircleIcon className={styles.quantityIcon} />
          </button>
        </div>
      </div>
      <div className={styles.infoProductButtonGroup}>
        <button
          className={`${styles.infoProductButton} ${styles.yellow}`}
          onClick={handleAddToCart}
          disabled={isAddToCartDisabled}
        >
          add to cart
        </button>
        <button className={`${styles.infoProductButton} ${styles.orange}`}>
          buy now
        </button>
      </div>
    </>
  );
};
const InfoProduct = ({
  data,
  categoryId,
  listImage,
  handleAddToCart,
  isAddToCartDisabled,
  quantity,
  handleSetQuantity,
  isAuction
}) => {
  const [nav1, setNav1] = useState();
  const [nav2, setNav2] = useState();

  const settings = {
    infinite: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    nextArrow: <SampleNextArrow />,
    prevArrow: <SamplePrevArrow />
  };
  const settings2 = { arrows: false };

  const [appState, { closeDrawer, toggleDrawer }] = useAppContext();
  const { drawer } = appState;
  const isOpen = drawer === 'report';
  const isOpenCountPeople = drawer === 'count-people';

  const breadcrumbs = categoryId ? (
    <Breadcrumbs categoryId={categoryId} currentProduct={data.name} />
  ) : null;

  const newListImage = listImage.filter(item => item.disabled === false) || [];

  const [isOpenSeeMore, setIsOpenSeeMore] = useState(false);

  const ReportRef = useRef(null);
  useEffect(() => {
    function handleClickOutside(event) {
      if (ReportRef.current && !ReportRef.current.contains(event.target)) {
        setIsOpenSeeMore(false);
      } else {
      }
    }
    // Bind the event listener
    document.addEventListener('mousedown', handleClickOutside);

    return () => {
      // Unbind the event listener on clean up
      document.removeEventListener('mousedown', handleClickOutside);
    };
  }, [ReportRef]);

  const [reasonReport, setReasonReport] = useState([
    { isChecked: false, reason: 'illegal products' },
    {
      isChecked: false,
      reason:
        'Product type does not match the conditions such as selling amulets, selling houses, selling mobile phones'
    },
    {
      isChecked: false,
      reason: `Posting products that don't match Catergory, for example posting 18+ products in Cat Education Toy`
    },
    {
      isChecked: false,
      reason:
        'Wrong product information such as name or description does not match the product.'
    },
    {
      isChecked: false,
      reason: 'Other (please specify)'
    }
  ]);

  const [reasonValue, setReasonValue] = useState('');

  const handleCheck = useCallback(
    ({ index }) => {
      let a = reasonReport;
      setReasonReport(a.map((r, i) => ({ ...r, isChecked: i === index })));
      setReasonValue(
        a[index].reason === 'Other (please specify)' ? '' : a[index].reason
      );
    },
    [setReasonReport]
  );

  const handleSubmit = e => {
    e.preventDefault();
    window.alert(reasonValue);
  };

  return (
    <div className={styles.infoProductContainer}>
      <div className={styles.infoProductLeft}>
        <div className={styles.infoProductListImage}>
          <div className={styles.boxImageContain}>
            <Slider
              asNavFor={nav2}
              ref={slider1 => setNav1(slider1)}
              {...settings}
            >
              {listImage.map((item, index) => (
                <div className={styles.imageContainItem} key={index}>
                  <img
                    src={
                      new URL(
                        generateUrlFromContainerWidth(`${item.file}`),
                        'https://192.168.1.108/'
                      ).href
                    }
                    alt={item.label}
                    loading="lazy"
                    className={styles.containItemImg}
                  />
                </div>
              ))}
            </Slider>
          </div>
          <div className={styles.boxListImage}>
            <Slider
              asNavFor={nav1}
              ref={slider2 => setNav2(slider2)}
              slidesToShow={3}
              swipeToSlide={true}
              focusOnSelect={true}
              {...settings2}
            >
              {newListImage.map((item, index) => (
                <div className={styles.imageItem} key={index}>
                  <img
                    src={
                      new URL(
                        generateUrlFromContainerWidth(`${item.file}`),
                        'https://192.168.1.108/'
                      ).href
                    }
                    alt={item.label}
                    loading="lazy"
                    className={styles.itemImg}
                  />
                </div>
              ))}
              {newListImage.length < 3 &&
                Array(3 - newListImage.length)
                  .fill(0)
                  .map((item, index) => (
                    <span style={{ display: 'none' }} key={index} />
                  ))}
            </Slider>
          </div>
        </div>
        <div className={styles.infoProductTool}>
          <button className={styles.toolButton}>
            <ShareIcon className={styles.toolIcon} style={{ color: 'blue' }} />
            share
          </button>
          <button className={styles.toolButton}>
            <HeartIcon className={styles.toolIcon} style={{ color: 'red' }} />
            interested products
          </button>
          <div style={{ position: 'relative' }}>
            <button
              type="button"
              className={styles.toolButton}
              onClick={() => setIsOpenSeeMore(prev => !prev)}
            >
              <MoreIcon
                className={styles.toolIcon}
                style={{ color: 'orange' }}
              />
              see more
            </button>
            <div
              ref={ReportRef}
              className={`${styles.seeMoreContent} ${isOpenSeeMore &&
                styles.active}`}
              onClick={() => toggleDrawer('report')}
            >
              <ReportIcon
                className={styles.toolIcon}
                style={{ color: 'red' }}
              />
              <p className={styles.contentText}>Report</p>
            </div>
          </div>
        </div>
      </div>

      <div className={styles.infoProductRight}>
        {isAuction ? (
          <InfoProductAuction toggleDrawer={toggleDrawer} />
        ) : (
          <InfoProductNormal
            data={data}
            breadcrumbs={breadcrumbs}
            handleAddToCart={handleAddToCart}
            handleSetQuantity={handleSetQuantity}
            isAddToCartDisabled={isAddToCartDisabled}
            quantity={quantity}
          />
        )}
      </div>

      {/* Modal report */}
      <aside
        className={`modal-popup p-0 modal-popup-right ${
          isOpen ? `active active-slide-in-right` : ''
        }`}
      >
        <div className={`${styles.popupBox}`}>
          <div className={styles.popupHeader}>
            <i>
              <LeftIcon className={styles.closeIcon} onClick={closeDrawer} />
            </i>
            <h1 className={styles.titlePopup}>Report</h1>
          </div>
          <div className={styles.popupBody}>
            <div className={styles.listRadio}>
              {reasonReport.map((item, index) => (
                <div className={styles.radioItem} key={index}>
                  <RadioInput
                    title={item.reason}
                    isChecked={item.isChecked}
                    handleCheck={handleCheck}
                    index={index}
                  />
                </div>
              ))}
            </div>
            <form onSubmit={handleSubmit} className={styles.formContainer}>
              {/* <TextInput fieldState={{ value: reasonValue }} /> */}
              <div className={styles.inputItem}>
                <textarea
                  className={styles.inputField}
                  rows="10"
                  type="textarea"
                  value={reasonValue}
                  onChange={e => setReasonValue(e.target.value)}
                />
              </div>
              <div className={styles.buttonGroup}>
                <button
                  type="button"
                  className={styles.buttonItem}
                  onClick={closeDrawer}
                >
                  Cancel
                </button>
                <button
                  type="submit"
                  className={styles.buttonItem}
                  disabled={!reasonValue && true}
                >
                  Confirm
                </button>
              </div>
            </form>
          </div>
        </div>
      </aside>

      {/* Modal amount people */}
      <aside
        className={`modal-popup p-0 modal-popup-right ${
          isOpenCountPeople ? `active active-slide-in-right` : ''
        }`}
      >
        <div className={`${styles.popupBox}`}>
          <div className={styles.popupHeader}>
            <i>
              <LeftIcon className={styles.closeIcon} onClick={closeDrawer} />
            </i>
            <h1 className={styles.titlePopup}>BID History</h1>
          </div>
          <div className={styles.popupBody} />
        </div>
      </aside>
    </div>
  );
};

export default InfoProduct;
