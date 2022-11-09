import React from 'react'
import styles from './listAdvertise.module.scss'

const ListAdvertise = () => {
  return (
    <div className={styles.listAdvertiseContainer}>
      <div className={styles.listAdvertiseBox}>
        <div className={styles.listAdvertiseItem}>
          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT4qPmyou8HM0n-ia6ZoZYnSPZDyiyfE1Rxlw&usqp=CAU" alt="" className={styles.listAdvertiseItemImg} loading="lazy"/>
        </div>
        <div className={styles.listAdvertiseItem}>
          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT4qPmyou8HM0n-ia6ZoZYnSPZDyiyfE1Rxlw&usqp=CAU" alt="" className={styles.listAdvertiseItemImg} loading="lazy"/>
        </div>
        <div className={styles.listAdvertiseItem}>
          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT4qPmyou8HM0n-ia6ZoZYnSPZDyiyfE1Rxlw&usqp=CAU" alt="" className={styles.listAdvertiseItemImg} loading="lazy"/>
        </div>
      </div>
    </div>
  )
}

export default ListAdvertise