import React, { useEffect } from 'react'
import Banner from '../../components/Banner/banner'
import BannerAdvertise from '../../components/BannerAdvertise'
import ListProduct from '../../components/ListProduct'
import MainCategory from '../../components/MainCategory'
import styles from './hotDeal.module.scss'

const HotDeal = () => {
  useEffect(() => {
    window.scrollTo(0,0)
  }, [])
  
  return (
    <div className={styles.hotDealContainer}>
    <div className='container'>
      <section className={styles.hotDealBanner}><Banner dots={true}/></section>
      <section className={styles.hotDealListProduct}><ListProduct typeTitle="text" title="Recommend Product" isSlider={true} /></section>
      <section className={styles.hotDealBannerAdvertise}><BannerAdvertise/></section>
      <section className={styles.hotDealMainCategory}><MainCategory/></section>
      <section className={styles.hotDealListProduct}><ListProduct typeTitle='text' isSlider={false} isButton={true} title="Best Seller" isThroughTitle={true}/></section>
    </div>
    </div>
  )
}

export default HotDeal