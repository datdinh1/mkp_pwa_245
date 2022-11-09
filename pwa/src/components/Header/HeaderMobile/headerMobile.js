import React, { useEffect, useRef, useState } from 'react';
import {
  Bell as BellIcon,
  Search as SearchIcon,
  ShoppingBag as BagIcon
} from 'react-feather';
import { Link, NavLink } from 'react-router-dom';
import LOGO from '../../../styles/images/logo.png';
import styles from './headerMobile.module.scss';

const HeaderMobile = () => {
  const [searchContent, setSearchContent] = useState('');

  const [showBarSearch, setShowBarSearch] = useState(false);

  const handleChangeSearch = e => {
    setSearchContent(e.target.value);
    setShowBarSearch(true);
    if (!searchContent) {
      setShowBarSearch(false);
    }
  };

  const FormSearchRef = useRef(null);

  // ON CLICK OUTSIDE SEARCH FORM
  useEffect(() => {
    function handleClickOutside(event) {
      if (
        FormSearchRef.current &&
        !FormSearchRef.current.contains(event.target)
      ) {
        setShowBarSearch(false);
      } else {
      }
    }
    // Bind the event listener
    document.addEventListener('mousedown', handleClickOutside);

    return () => {
      // Unbind the event listener on clean up
      document.removeEventListener('mousedown', handleClickOutside);
    };
  }, [FormSearchRef]);

  return (
    <div className={styles.headerMobileContainer}>
      <div className={styles.headerMobileTop}>
        <div className={styles.headerMobileTopLeft}>
          <Link to="/">
            <img
              src={LOGO}
              alt="LOGO"
              className={styles.MobileLogo}
              loading="lazy"
            />
          </Link>
        </div>
        <ul className={styles.headerMobileTopRight}>
          <li className={styles.MobileIconItem}>
            <BellIcon className={styles.MobileIcon} />
          </li>
          <li className={styles.MobileIconItem}>
            <Link to="/cart">
              <BagIcon className={styles.MobileIcon} />
              <div className={styles.badge}>
                <span>10</span>
              </div>
            </Link>
          </li>
        </ul>
      </div>

      <div className={styles.headerMobileBottom}>
        {/* SEARCH FORM */}
        <form className={styles.headerMobileFormSearch} ref={FormSearchRef}>
          <input
            value={searchContent}
            onChange={e => handleChangeSearch(e)}
            onClick={() => setShowBarSearch(true)}
            type="text"
            placeholder="Type what you are looking for"
            className={styles.headerMobileSearchInput}
          />
          <div className={styles.searchIconItem}>
            <SearchIcon className={styles.searchIcon} />
          </div>
          {searchContent && showBarSearch === true && (
            <div className={styles.headerMobileSearchBar}>
              <p className={styles.headerMobileSearchText}>
                Search for {searchContent}
              </p>
            </div>
          )}
        </form>
        {/* LIST MENU ITEM */}
        <ul className={styles.headerMobileMenuList}>
          <li className={styles.headerMobileMenuItem}>
            <NavLink to="/" className={styles.headerMobileMenuLink} exact>
              Marketplace
            </NavLink>
          </li>
          <li className={styles.headerMobileMenuItem}>
            <NavLink to="/community" className={styles.headerMobileMenuLink}>
              Community
            </NavLink>
          </li>
          <li className={styles.headerMobileMenuItem}>
            <NavLink to="/auction" className={styles.headerMobileMenuLink}>
              Auction
            </NavLink>
          </li>
        </ul>
      </div>
    </div>
  );
};

export default HeaderMobile;
