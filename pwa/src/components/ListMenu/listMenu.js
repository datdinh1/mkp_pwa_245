import React from 'react';
import styles from './listMenu.module.scss';
import { Link } from 'react-router-dom';
import COUPON from '../../styles/images/coupon.png';
import FREESHIP from '../../styles/images/freeship.png';
import MALL from '../../styles/images/mall.png';
import NEW_ARRIVAL from '../../styles/images/new_arrival.png';
import SHOP from '../../styles/images/shop.png';
import Slider from 'react-slick';

const ListMenu = () => {
  const settings = {
    infinite: true,
    autoplay: true,
    speed: 1300,
    autoplaySpeed: 3500,
    slidesToShow: 5,
    slidesToScroll: 1,
    arrows: false,
    responsive: [
      {
        breakpoint: 1281,
        settings: {
          slidesToShow: 5,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 5,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 912,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 1
        }
      }
    ]
  };

  return (
    <div className={styles.listMenuContainer}>
      {/* <div className={styles.listMenuBox}> */}
      <Slider {...settings}>
        <div>
          <Link to={`/coupon`} className={styles.listMenuItem}>
            <div className={styles.listMenuItemTop}>
              <img
                src={COUPON}
                alt="COUPON"
                className={styles.listMenuItemTopImg}
                loading="lazy"
              />
            </div>
            <div className={styles.listMenuItemBottom}>
              <h6 className={styles.listMenuItemBottomTitle}>COUPON</h6>
            </div>
          </Link>
        </div>
        <div>
          <Link to={`/seller`} className={styles.listMenuItem}>
            <div className={styles.listMenuItemTop}>
              <img
                src={SHOP}
                alt="SHOP"
                className={styles.listMenuItemTopImg}
                loading="lazy"
              />
            </div>
            <div className={styles.listMenuItemBottom}>
              <h6 className={styles.listMenuItemBottomTitle}>START SELLING</h6>
            </div>
          </Link>
        </div>
        <div>
          <Link to={`/mall`} className={styles.listMenuItem}>
            <div className={styles.listMenuItemTop}>
              <img
                src={MALL}
                alt="MALL"
                className={styles.listMenuItemTopImg}
                loading="lazy"
              />
            </div>
            <div className={styles.listMenuItemBottom}>
              <h6 className={styles.listMenuItemBottomTitle}>MALL</h6>
            </div>
          </Link>
        </div>
        <div>
          <Link to={`/new-arrival`} className={styles.listMenuItem}>
            <div className={styles.listMenuItemTop}>
              <img
                src={NEW_ARRIVAL}
                alt=""
                className={styles.listMenuItemTopImg}
                loading="lazy"
              />
            </div>
            <div className={styles.listMenuItemBottom}>
              <h6 className={styles.listMenuItemBottomTitle}>9.9</h6>
            </div>
          </Link>
        </div>
        <div>
          <Link to={`/`} className={styles.listMenuItem}>
            <div className={styles.listMenuItemTop}>
              <img
                src={FREESHIP}
                alt=""
                className={styles.listMenuItemTopImg}
                loading="lazy"
              />
            </div>
            <div className={styles.listMenuItemBottom}>
              <h6 className={styles.listMenuItemBottomTitle}>FREE DELIVERY</h6>
            </div>
          </Link>
        </div>
      </Slider>
      {/* </div> */}
    </div>
  );
};

export default ListMenu;
