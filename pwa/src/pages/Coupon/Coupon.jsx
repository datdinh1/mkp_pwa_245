import React, { useEffect } from 'react'
import ListCoupon from '../../components/ListCoupon'
import styles from './coupon.module.scss'

const Coupon = () => {
  useEffect(() => {
    window.scrollTo(0,0)
  }, [])
  return (
    <div className={styles.couponContainer}>
      <div className='container'>
        <div className={styles.couponBody}>
            <section className={styles.couponListProduct}><ListCoupon/></section>
        </div>
      </div>
    </div>
  )
}

export default Coupon