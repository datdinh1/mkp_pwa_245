import React, { useEffect } from 'react'
import Banner from '../../components/Banner/banner'
import ListCouponCollect from '../../components/ListCouponCollect'
import SmallCategory from '../../components/SmallCategory'
import styles from './collectCoupon.module.scss'

const CollectCoupon = () => {
  useEffect(() => {
    window.scrollTo(0,0)
  }, [])
  return (
    <div className={styles.collectCouponContainer}>
    <div className='container'>
        <section className={styles.collectCouponBanner}><Banner dots={false}/></section>
        <section className={styles.collectCouponListCategory}><SmallCategory/></section>
        <section className={styles.collectCouponListCoupon}><ListCouponCollect isCategory={false} isTitle={true} title="Popular Store Coupons For You"/></section>
        <section className={styles.collectCouponListCoupon}><ListCouponCollect isCategory={true} isTitle={true} title="Coupons By Product Type"/></section>
        <section className={styles.collectCouponListCoupon}><ListCouponCollect isCategory={true} isTitle={false}/></section>
        <section className={styles.collectCouponListCoupon}><ListCouponCollect isCategory={true} isTitle={false}/></section>
    </div>
</div>
  )
}

export default CollectCoupon