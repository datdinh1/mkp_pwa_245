import React from 'react'
import { useTranslation } from 'react-i18next';
import {FileText as FileTextIcon} from 'react-feather'
import styles from './categoryAccountPage.module.scss'
import {Link} from 'react-router-dom'

const CategoryAccountPage = () => {
  const { t } = useTranslation('account');

  return (
    <div className={styles.categoryContainer}>
      
      <Link to='/account/orders' className={styles.categoryItem}>
        <div className={styles.categoryItemTop}>
          <i><FileTextIcon className={styles.categoryIcon}/></i>
        </div>
        <div className={styles.categoryItemBottom}>
          <p className={styles.categoryTitle}>
            {t('My Order List')}
          </p>
        </div>
      </Link>
      <Link to="/shop/SELLER74" className={styles.categoryItem}>
        <div className={styles.categoryItemTop}>
          <i><FileTextIcon  className={styles.categoryIcon}/></i>
        </div>
        <div className={styles.categoryItemBottom}>
          <p className={styles.categoryTitle}>
            {t('Home Page')}
          </p>
        </div>
      </Link>
      <Link to='/seller' className={styles.categoryItem}>
        <div className={styles.categoryItemTop}>
          <i><FileTextIcon  className={styles.categoryIcon}/></i>
        </div>
        <div className={styles.categoryItemBottom}>
          <p className={styles.categoryTitle}>
            {t('Seller Management')}
          </p>
        </div>
      </Link>
    </div>
  )
}

export default CategoryAccountPage