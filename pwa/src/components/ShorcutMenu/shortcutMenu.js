import React from 'react';
import { List as ListIcon } from 'react-feather';
import { useTranslation } from 'react-i18next';
import { Link } from 'react-router-dom';
import styles from './shortcutMenu.module.scss';

const ShortcutMenu = () => {
    const { t } = useTranslation('account');

    return (
        <div className={styles.shortcutMenuContainer}>
            <div className={styles.shortcutMenuTitle}>
                <i><ListIcon className={styles.shortcutIcon}/></i>
                <h1 className={styles.shortcutMenuText}>Shortcut Menu</h1>
            </div>
            <div className={styles.listShortcutMenu}>
                <Link to='/account/favourite' className={styles.shortcutMenuItem}>
                    <div  className={styles.menuItemIcon}>
                        <span className={`${styles.menuIcon} material-symbols-outlined`}>
                            favorite
                        </span> 
                    </div>
                    <p className={styles.menuItemTitle}>{t('Favourite')}</p>
                </Link>

                <Link to='/account/coupon' className={styles.shortcutMenuItem}>
                    <div className={styles.menuItemIcon}>
                        <span className={`${styles.menuIcon} material-symbols-outlined`} >
                            confirmation_number
                        </span>
                    </div>
                    <p className={styles.menuItemTitle}>{t('My Coupons')}</p>
                </Link>
                
                <Link to='/account/followers' className={styles.shortcutMenuItem}>
                    <div className={styles.menuItemIcon}>
                        <span className={`${styles.menuIcon} material-symbols-outlined`}>
                            library_add_check
                        </span>
                    </div>
                    <p className={styles.menuItemTitle}>{t('Follower')}</p>
                </Link>

                <Link to='/account/recently-viewed' className={styles.shortcutMenuItem}>
                    <div className={styles.menuItemIcon}>
                        <span className={`${styles.menuIcon} material-symbols-outlined`}>
                            update
                        </span>
                    </div>
                    <p className={styles.menuItemTitle}>{t('Recently Viewed')}</p>
                </Link>
            </div>
        </div>
    )
}

export default ShortcutMenu