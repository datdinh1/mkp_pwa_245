import React, { useEffect } from 'react'
import Banner from '../../components/Banner/banner'
import ListProduct from '../../components/ListProduct'
import MainCategory from '../../components/MainCategory'
import styles from './newArrival.module.scss'

const NewArrival = () => {
  useEffect(() => {
    window.scrollTo(0,0)
  }, [])

  return (
    <div className={styles.newArrivalContainer}>
    <div className='container'>
      <section className={styles.newArrivalBanner}><Banner dots={true}/></section>
      <section className={styles.newArrivalListProduct}><ListProduct typeTitle="text" title="Recommend Product" isSlider={true} /></section>
      <section className={styles.newArrivalMainCategory}><MainCategory/></section>
      <section className={styles.newArrivalListProduct}><ListProduct typeTitle='text' isSlider={false} isButton={true} title="Best Seller" isThroughTitle={true}/></section>
    </div>
  </div>
  )
}

export default NewArrival