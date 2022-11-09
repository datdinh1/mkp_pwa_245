import React from 'react'
import styles from './bannerAdvertise.module.scss'
const BannerAdvertise = () => {
  return (
    <div className={styles.bannerAdvertiseContainer}>
        <img className={styles.bannerAdvertiseImg} src='https://helpx.adobe.com/content/dam/help/en/photoshop/using/convert-color-image-black-white/jcr_content/main-pars/before_and_after/image-before/Landscape-Color.jpg' alt='' loading="lazy"/>
    </div>
  )
}

export default BannerAdvertise