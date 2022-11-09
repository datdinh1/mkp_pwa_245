import React, { useEffect, useRef, useState } from 'react';
import {
  Bell as BellIcon,
  Search as SearchIcon,
  ShoppingBag as BagIcon
} from 'react-feather';
import { Link, NavLink } from 'react-router-dom';
import LOGO from '../../../styles/images/logo_02.png';
import LOGOSMALL from '../../../styles/images/logo_seller.png';
import styles from './headerPC.module.scss';

const HeaderPC = () => {
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
    <div className={styles.headerPcContainer}>
      <div className={styles.headerPcLeft}>
        <Link to="/">
          <img
            src={LOGO}
            alt="LOGO"
            className={styles.headerPcLogo}
            loading="lazy"
          />
          <img
            src={LOGOSMALL}
            alt="LOGO"
            className={styles.headerPcLogoSmall}
            loading="lazy"
          />
        </Link>
      </div>
      <div className={styles.headerPcMiddle}>
        {/* SEARCH FORM */}
        <form className={styles.headerPcFormSearch} ref={FormSearchRef}>
          <input
            value={searchContent}
            onChange={e => handleChangeSearch(e)}
            onClick={() => setShowBarSearch(true)}
            type="text"
            placeholder="Type what you are looking for"
            className={styles.headerPcSearchInput}
          />
          <div className={styles.searchIconItem}>
            <SearchIcon className={styles.searchIcon} />
          </div>
          {searchContent && showBarSearch === true && (
            <div className={styles.headerPcSearchBar}>
              <p className={styles.headerPcSearchText}>
                Search for {searchContent}
              </p>
            </div>
          )}
        </form>
        {/* LIST MENU ITEM */}
        <ul className={styles.headerPcMenuList}>
          <li className={styles.headerPcMenuItem}>
            <NavLink
              to="/"
              className={`${styles.headerPcMenuLink}`}
              activeClassName={styles.active}
              exact
            >
              Marketplace
            </NavLink>
          </li>
          <li className={styles.headerPcMenuItem}>
            <NavLink
              to="/community"
              className={styles.headerPcMenuLink}
              activeClassName={styles.active}
            >
              Community
            </NavLink>
          </li>
          <li className={styles.headerPcMenuItem}>
            <NavLink
              to="/auction"
              className={styles.headerPcMenuLink}
              activeClassName={styles.active}
            >
              Auction
            </NavLink>
          </li>
        </ul>
      </div>
      <ul className={styles.headerPcRight}>
        <li className={styles.headerPcIconItem}>
          <BellIcon className={styles.headerPcIcon} />
        </li>
        <li className={styles.headerPcIconItem}>
          <Link to="cart">
            <BagIcon className={styles.headerPcIcon} />
            <div className={styles.badge}>
              <span>10</span>
            </div>
          </Link>
        </li>
      </ul>
    </div>
  );
};

export default HeaderPC;
