import React from 'react'
import ListProduct from '../../components/ListProduct/listProduct'
import styles from './recentlyViewed.module.scss'

const RecentlyViewed = () => {
  return (
    <div className={styles.recentlyViewedContainer}>
        <div className='container'>
            <section className={styles.recentlyViewedListProduct}><ListProduct isButton={false} title='Recently Viewed' typeTitle='text' isSlider={false} /></section>
        </div>
    </div>
  )
}

export default RecentlyViewed