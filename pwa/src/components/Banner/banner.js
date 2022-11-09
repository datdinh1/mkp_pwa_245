import React, { useState } from 'react';
import styles from './banner.module.scss';
import Slider from 'react-slick';

const Banner = ({ dots, data }) => {
  const [currentSlide, setcurrentSlide] = useState(0);

  var settings = {
    dots: dots,
    infinite: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: true,
    speed: 1300,
    autoplaySpeed: 3000,
    arrows: false,
    beforeChange: (prev, next) => {
      setcurrentSlide(next);
    },
    customPaging: i => (
      <div
        className={`${i === currentSlide && styles.dotActive} ${styles.dots}`}
      />
    )
  };

  return (
    <div className={styles.bannerContainer}>
      {data && (
        <div className={styles.bannerBox}>
          <Slider {...settings}>
            {data.items.map((item, index) => (
              <div
                className={styles.bannerItem}
                key={index}
                dangerouslySetInnerHTML={{ __html: item.content }}
              >
                {/* <img src={item.content.split('"')[1]} alt={item.title} className={styles.bannerImg} loading="lazy"/> */}
              </div>
            ))}
          </Slider>
        </div>
      )}
    </div>
  );
};

export default Banner;
