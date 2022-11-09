import React from 'react'
import styles from './coupon.module.scss'
const Coupon = () => {
  return (
    <div className={styles.couponContainer}>
        <div className={styles.couponTitle}>
            <h1 className={styles.couponText}>Coupon For Your</h1>
        </div>
        <div className={styles.listCoupon}>
            <div className={styles.couponItem}>
                <div className={styles.itemImage}>
                    <img src='' alt='' className={styles.itemImg} loading='lazy'/>
                </div>
            </div>
        </div>
    </div>
  )
}

export default Coupon