import React from 'react'
import styles from './mainCategory.module.scss'

const MainCategory = () => {

  return (
    <div className={styles.categoryContainer}>
      <div className={styles.categoryHeader}>
        <h1 className={styles.categoryHeaderTitle}>Main Category</h1>
      </div>
      {/* LIST CATEGORY */}
      <div className={styles.listCategory}>
          {Array(8).fill(0).map((item, index) => (
            <div className={styles.categoryItem} key={index}>
              <div className={styles.categoryImage}>
                <img src='https://product.hstatic.net/1000190106/product/playstation-5-games-console-transparent-background-png-image_ae355ee20c9c416fb70a68f47f8591e8_medium.png' alt='' className={styles.categoryImg} loading="lazy"/>
              </div>
              <div className={styles.categoryTitle}>
                <h5 className={styles.categoryTitleText}>PlayStation 5</h5>
              </div>
            </div>
          ))}
      </div>
    </div>
  )
}

export default MainCategory