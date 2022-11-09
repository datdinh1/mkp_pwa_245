import React, { useEffect } from 'react'
import Banner from '../../components/Banner/banner'
import CategoryAccountPage from '../../components/CategoryAccountPage'
import Coupon from '../../components/Coupon'
import RecentUpdate from '../../components/RecentUpdate/recentUpdate'
import ShortcutMenu from '../../components/ShorcutMenu/shortcutMenu'
import styles from './account.module.scss'

const Account = () => {

  useEffect(() => {
    window.scrollTo(0,0)
  }, [])
  
  return (
    <div className={styles.accountContainer}>
        <div className='container'>
            <section className={styles.accountBanner}><Banner dots={true}/></section>
            <div className={styles.accountBody}>
              <section className={styles.accountCategory}><CategoryAccountPage/></section>
              <hr className='text-gray'/>
              <section className={styles.accountRecentUpdate}><RecentUpdate/></section>
              {/* <section className={styles.accountCoupon}><Coupon/></section> */}
              <section className={styles.accountShortcutMenu}><ShortcutMenu/></section>
            </div>
        </div>
    </div>
  )
}

export default Account