import { useAppContext } from '@magento/peregrine/lib/context/app';
import React from 'react';
import {
  Home as HomeIcon,
  List as ListIcon,
  MessageSquare as MessageIcon,
  ShoppingCart as CartIcon,
  User as UserIcon
} from 'react-feather';
import { Link } from 'react-router-dom';
import PopupMenu from '../PopupMenu';
import styles from './toggleMobile.module.scss';

const ToggleMobbile = () => {
  const [appState, { closeDrawer, toggleDrawer }] = useAppContext();
  return (
    <div className={styles.toggleMobbileContainer}>
      <ul className={styles.menuList}>
        <li className={styles.menuItem}>
          <div onClick={() => toggleDrawer('menu-list')}>
            <i>
              <ListIcon className={` ${styles.menuIcon}`} />
            </i>
          </div>
          <i />
        </li>
        <li className={styles.menuItem}>
          <Link to="/">
            <i>
              <HomeIcon className={` ${styles.menuIcon}`} />
            </i>
          </Link>
          <i />
        </li>
        <li className={styles.menuItem}>
          <Link to="/chat/list">
            <i>
              <MessageIcon className={` ${styles.menuIcon}`} />
            </i>
          </Link>
          <i />
        </li>
        <li className={styles.menuItem}>
          <Link to="/cart">
            <i>
              <CartIcon className={` ${styles.menuIcon}`} />
            </i>
          </Link>
          <i />
        </li>
        <li className={styles.menuItem}>
          <Link to="/account">
            <i>
              <i>
                <UserIcon className={` ${styles.menuIcon}`} />
              </i>
            </i>
          </Link>
          <i />
        </li>
      </ul>
      <PopupMenu />
    </div>
  );
};

export default ToggleMobbile;
