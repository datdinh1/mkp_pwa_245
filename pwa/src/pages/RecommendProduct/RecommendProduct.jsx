import React, { useEffect } from 'react'
import Banner from '../../components/Banner/banner'
import ListProduct from '../../components/ListProduct'
import MainCategory from '../../components/MainCategory'
import styles from './recommendProduct.module.scss'

const RecommendProduct = () => {
  useEffect(() => {
    window.scrollTo(0,0)
  }, [])

  return (
    <div className={styles.recommendProductContainer}>
    <div className='container'>
      <section className={styles.recommendProductBanner}><Banner dots={true}/></section>
      <section className={styles.recommendProductMainCategory}><MainCategory/></section>
      <section className={styles.recommendProductListProduct}><ListProduct typeTitle='text' isSlider={false} isButton={true} title="Best Seller" isThroughTitle={true}/></section>
    </div>
</div>
  )
}

export default RecommendProduct