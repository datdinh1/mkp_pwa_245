import React from 'react'
import styles from './smallCategory.module.scss'
import AVATAR from '../../styles/images/avatar.jpg'
const SmallCategory = () => {
  return (
    <div className={styles.smallCategoryContainer}>
      <div className={styles.smallCategoryListItem}>
        {Array(6).fill(0).map((item,index) => (
          <div className={styles.item} key={index}>
            <div className={styles.itemImage}>
              <img src={AVATAR} alt='' className={styles.itemImg} loading='lazy'/>
            </div>
            <div className={styles.itemTitle}>
              <h5 className={styles.itemTitleText}>Category</h5>
            </div>
          </div>
        ))}
      </div>
    </div>
  )
}

export default SmallCategory