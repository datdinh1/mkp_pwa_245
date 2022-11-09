import React from 'react'
import { Link } from 'react-router-dom'
import styles from './setting.module.scss'
import {ChevronRight as RightIcon, User as UserIcon} from 'react-feather'
import { useTranslation } from 'react-i18next';

const Setting = () => {
  const { t } = useTranslation('setting');
  return (
    <div  className={styles.settingContainer}>
        <div className='container'>
            <div className={styles.settingBody}>
                <section className={styles.settingMenu}>
                  <div className={styles.settingMenuContainer}>
                    <div className={styles.settingMenuTitle}>
                      <h3 className={styles.titleText}>{t('Account')}</h3>
                    </div>
                    <div className={styles.menuList}>
                      <Link to='/account/settings/profile' className={styles.menuItem}>
                        <div className={styles.itemLeft}>
                          <span className={`${styles.itemIcon} material-symbols-outlined`}>
                            manage_accounts
                          </span>
                          <span className={styles.itemName}>{t('Set Up Personal Information')}</span>
                        </div>
                        <div className={styles.itemRight}>
                          <i><RightIcon className={styles.rightIcon}/></i> 
                        </div>
                      </Link>

                      <Link to='/account/settings/delivery-address' className={styles.menuItem}>
                        <div className={styles.itemLeft}>
                          <span className={`${styles.itemIcon} material-symbols-outlined`}>
                            pin_drop
                          </span>
                          <span className={styles.itemName}>{t('Delivery Address')}</span>
                        </div>
                        <div className={styles.itemRight}>
                          <i><RightIcon className={styles.rightIcon}/></i> 
                        </div>
                      </Link>

                      <Link to='/account/settings/payment-methods' className={styles.menuItem}>
                        <div className={styles.itemLeft}>
                          <span className={`${styles.itemIcon} material-symbols-outlined`}>
                            credit_score
                          </span>
                          <span className={styles.itemName}>{t('Payment Method')}</span>
                        </div>
                        <div className={styles.itemRight}>
                          <i><RightIcon className={styles.rightIcon}/></i> 
                        </div>
                      </Link>
                    </div>
                  </div>
                </section>

                <section className={styles.settingMenu}>
                  <div className={styles.settingMenuContainer}>
                    <div className={styles.settingMenuTitle}>
                      <h3 className={styles.titleText}>{t('Set Up')}</h3>
                    </div>
                    <div className={styles.menuList}>
                      <Link to='/account/settings/chat' className={styles.menuItem}>
                        <div className={styles.itemLeft}>
                          <span className={`${styles.itemIcon} material-symbols-outlined`}>
                            sms
                          </span>
                          <span className={styles.itemName}>{t('chat settings')}</span>
                        </div>
                        <div className={styles.itemRight}>
                          <i><RightIcon className={styles.rightIcon}/></i> 
                        </div>
                      </Link>
                    </div>
                  </div>
                </section>
                
                <section className={styles.settingMenu}>
                  <div className={styles.settingMenuContainer}>
                    <div className={styles.settingMenuTitle}>
                      <h3 className={styles.titleText}>{t('Help')}</h3>
                    </div>
                    <div className={styles.menuList}>
                      <Link to='#' className={styles.menuItem}>
                        <div className={styles.itemLeft}>
                          <span className={`${styles.itemIcon} material-symbols-outlined`}>
                            help_center
                          </span>
                          <span className={styles.itemName}>{t('Help Center')}</span>
                        </div>
                        <div className={styles.itemRight}>
                          <i><RightIcon className={styles.rightIcon}/></i> 
                        </div>
                      </Link>
                      <Link to='#' className={styles.menuItem}>
                        <div className={styles.itemLeft}>
                          <span className={`${styles.itemIcon} material-symbols-outlined`}>
                            policy
                          </span>
                          <span className={styles.itemName}>{t('Rules Of Use')}</span>
                        </div>
                        <div className={styles.itemRight}>
                          <i><RightIcon className={styles.rightIcon}/></i> 
                        </div>
                      </Link>
                      <Link to='#' className={styles.menuItem}>
                        <div className={styles.itemLeft}>
                          <span className={`${styles.itemIcon} material-symbols-outlined`}>
                            local_police
                          </span>
                          <span className={styles.itemName}>{t('Nurse Policy')}</span>
                        </div>
                        <div className={styles.itemRight}>
                          <i><RightIcon className={styles.rightIcon}/></i> 
                        </div>
                      </Link>
                      <Link to='#' className={styles.menuItem}>
                        <div className={styles.itemLeft}>
                          <i><UserIcon className={styles.itemIcon}/></i>
                          <span className={styles.itemName}>{t('About Nurse')}</span>
                        </div>
                        <div className={styles.itemRight}>
                          <i><RightIcon className={styles.rightIcon}/></i> 
                        </div>
                      </Link>
                      <Link to='/account/settings/delete-account' className={styles.menuItem}>
                        <div className={styles.itemLeft}>
                          <span className={`${styles.itemIcon} material-symbols-outlined`}>
                            no_accounts
                          </span>
                          <span className={styles.itemName}>{t('Request To Delete User Account')}</span>
                        </div>
                        <div className={styles.itemRight}>
                          <i><RightIcon className={styles.rightIcon}/></i> 
                        </div>
                      </Link>
                    </div>
                  </div>
                </section>
                
                <section className={styles.settingButton}>
                  <button className={styles.logoutButton}>{t('Log Out')}</button>
                </section>
            </div>
        </div>
    </div>
  )
}

export default Setting