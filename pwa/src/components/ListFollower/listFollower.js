import React, { useState } from 'react'
import styles from './listFollower.module.scss'
import { useTranslation } from 'react-i18next';
import AVATAR from '../../styles/images/avatar.jpg'
import DataNull from '../DataNull';
import {Link} from 'react-router-dom'

const ListFollower = () => {
  const { t } = useTranslation('follower');
  const [isTabChoose, setIsTabChoose] = useState({
    follower: true,
    following: false
  })

  const handleChooseTab = ({type}) => {
    switch (type) {
      case 'FOLLOWER':
        setIsTabChoose({
          follower:true,
          following:false
        })
        break;
        case 'FOLLOWING':
          setIsTabChoose({
            follower:false,
            following:true
          })
          break;
      default:
        break;
    }
  }

  return (
    <div className={styles.listFollowerContainer}>
      {/* TITLE */}
      <div className={styles.listFollowerTitle}>
        <h1 className={styles.listFollowerTitleText}>{t('Store Tracking')}</h1>
      </div>
      <div className={styles.listFollowerWishListContainer}>
        <div className={styles.wishListTabGroup}>
          <div className={styles.tabFollow} onClick={() => handleChooseTab({type:'FOLLOWER'})}>
            <p className={`${styles.followText} ${isTabChoose.follower && styles.active}`}>{t('Follower')}</p>
          </div>
          <div className={styles.tabFollow} onClick={() => handleChooseTab({type:'FOLLOWING'})}>
            <p className={`${styles.followText} ${isTabChoose.following && styles.active}`}>{t('Following')}</p>
          </div>
        </div>
        {isTabChoose.follower && (
          <div className={styles.listItem}>
            {Array(2).fill(0).map((item,index) => (
              <div className={styles.item} key={index}>
                <Link to='/' className={styles.itemLeft}>
                  <div className={styles.itemImage}>
                    <img src={AVATAR} alt='' className={styles.itemImg} loading='lazy'/>
                  </div>
                  <div className={styles.itemTitle}>
                    <h6 className={styles.itemTitleText}>Luffy Shop</h6>
                  </div>
                </Link>
                <div className={styles.itemRight}>
                  <div className={styles.itemButton}>
                    <span className={`${styles.buttonUnfollow} ${styles.follower}`}>{t('Following')}</span>
                  </div>
                </div>
              </div>
            ))}
          </div>
        )}

        {isTabChoose.following && (
          <div className={styles.listItem}>
            {Array(5).fill(0).map((item,index) => (
              <div className={styles.item} key={index}>
                <Link to='/' className={styles.itemLeft}>
                  <div className={styles.itemImage}>
                    <img src={AVATAR} alt='' className={styles.itemImg} loading='lazy'/>
                  </div>
                  <div className={styles.itemTitle}>
                    <h6 className={styles.itemTitleText}>Luffy Shop</h6>
                  </div>
                </Link>
                <div className={styles.itemRight}>
                  <div className={styles.itemButton}>
                    <button className={styles.buttonUnfollow}>unfollow</button>
                  </div>
                </div>
              </div>
            ))}
          </div>

          // <div className={styles.dataNull}><DataNull notice="please try again" /></div>
        )}
      </div>
    </div>
  )
}

export default ListFollower