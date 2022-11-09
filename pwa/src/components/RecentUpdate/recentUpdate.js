import React, { useState } from 'react'
import styles from './recentUpdate.module.scss'
import { useTranslation } from 'react-i18next';
import Avatar from '../../styles/images/avatar.jpg'
import {ChevronRight as RightIcon} from 'react-feather'
import DataNull from '../DataNull/dataNull';

const RecentUpdate = () => {
  const { t } = useTranslation('account');

  const [buttonActive, setbuttonActive] = useState({
    myOrder: true,
    storeOrder: false
  })

  const handleChooseCate = ({type}) => {
    switch (type) {

      case 'MY_ORDER':
        setbuttonActive({
          myOrder: true,
          storeOrder:false
        })
        break;

        case 'STORE_ORDER':
          setbuttonActive({
            myOrder: false,
            storeOrder: true,
          })
          break;
          
      default:
        break;
    }
  }

  return (
    <div className={styles.recentUpdateContainer}>
      <div className={styles.recentUpdateTitle}>
        <h1 className={styles.recentUpdateText}>Recent Update</h1>
      </div>
      <div className={styles.recentUpdateButtonGroup}>
        <button type='button' onClick={() => handleChooseCate({type:'MY_ORDER'})} className={`${styles.recentUpdateButton} ${buttonActive.myOrder === true && styles.active}`}>{t('My Order')}</button>
        <button type='button' onClick={() => handleChooseCate({type:'STORE_ORDER'})} className={`${styles.recentUpdateButton} ${buttonActive.storeOrder === true && styles.active}`}>{t('Store Order')}</button>
      </div>

      {buttonActive.myOrder === true && (
        <>
          <div className={styles.listItem}>
            {Array(3).fill(0).map((item,index) => (
              <div className={styles.item} key={index}>
                <div className={styles.itemLeft}>
                  <div className={styles.itemImage}>
                    <img src={Avatar} alt='' className={styles.itemImg} loading='lazy'/>
                  </div>

                  <div className={styles.itemContent}>
                    <p className={styles.itemIdText}>Order id #2208290001510</p>
                    <span className={styles.itemShopText}>fafarii shop</span>
                  </div>

                </div>
                <div className={styles.itemRight}>
                  <p className={styles.itemStatusText}>{t('Paid')}</p>
                </div>
              </div>
            ))}
          </div>
          <div className={styles.buttonArea}>
            <button className={styles.buttonSeeMore}>See more<i><RightIcon className={styles.buttonIcon}/></i></button>
          </div>
        </>
      )}
       
      {buttonActive.storeOrder === true && (
        <div className={styles.dataNull}><DataNull notice="Please try again"/></div>
      )}

    </div>
  )
}

export default RecentUpdate