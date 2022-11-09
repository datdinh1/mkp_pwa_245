import { useAppContext } from '@magento/peregrine/lib/context/app';
import React, { useState } from 'react';
import {
  X as CloseIcon,
  ChevronRight as RightIcon,
  ChevronLeft as LeftIcon
} from 'react-feather';
import { Link } from 'react-router-dom';
import styles from './popupMenu.module.scss';

const dataMenuToyModel = [
  {
    link: '/toy-models/scale-figure.html',
    name: 'Scale Figure'
  },
  {
    link: '/toy-models/plastic-model.html',
    name: 'Flastic Model'
  },
  {
    link: '/toy-models/action-figure.html',
    name: 'Action Figure'
  },
  {
    link: '/toy-models/designer-toy.html',
    name: 'Designer Toy'
  },
  {
    link: '/toy-models/garage-kit.html',
    name: 'Garage Kit'
  },
  {
    link: '/toy-models/statue.html',
    name: 'Statue'
  },
  {
    link: '/toy-models/replica-props.html',
    name: 'Replica & Props'
  },
  {
    link: '/toy-models/miniature.html',
    name: 'Miniature'
  },
  {
    link: '/toy-models/doll.html',
    name: 'Doll'
  },
  {
    link: '/toy-models/diorama.html',
    name: 'Diorama'
  },
  {
    link: '/toy-models/gachapon.html',
    name: 'Gachapon'
  },
  {
    link: '/toy-models/paint-tools.html',
    name: 'Paint & Tools'
  },
  {
    link: '/toy-models/kids-toy.html',
    name: 'Kids Toy'
  },
  {
    link: '/toy-models/education-toys.html',
    name: 'Education Toys'
  },
  {
    link: '/toy-models/18.html',
    name: '18+'
  }
];

const dataMenuPublication = [
  {
    link: '/gear/comic-book.html',
    name: 'Comic Book'
  },
  {
    link: '/gear/dojin.html',
    name: 'Dojin'
  },
  {
    link: '/gear/artbook.html',
    name: 'Artbook'
  },
  {
    link: '/gear/art-print.html',
    name: 'Art Print'
  },
  {
    link: '/gear/novel.html',
    name: 'Rovel'
  }
];

const ToyAndModelMenu = ({ setIsOpenModelMenu }) => {
  return (
    <ul className={`${styles.menuList}`}>
      <li
        className={`${styles.menuItem}`}
        onClick={() => setIsOpenModelMenu(false)}
      >
        <p className={`${styles.menuLink}`}>
          Back
          <i>
            <LeftIcon className={styles.arrowIcon} />
          </i>
        </p>
      </li>
      <li className={styles.menuItem}>
        <Link className={styles.menuLink} to="/toy-models.html">
          Toy & Model
        </Link>
      </li>
      {dataMenuToyModel.map((item, index) => (
        <li className={`${styles.menuItem} ${styles.child}`} key={index}>
          <Link className={`${styles.menuLink} ${styles.child}`} to={item.link}>
            {item.name}
          </Link>
        </li>
      ))}
    </ul>
  );
};

const PublicationMenu = ({ setIsOpenPublicationMenu }) => {
  return (
    <ul className={`${styles.menuList}`}>
      <li
        className={`${styles.menuItem}`}
        onClick={() => setIsOpenPublicationMenu(false)}
      >
        <p className={`${styles.menuLink}`}>
          Back
          <i>
            <LeftIcon className={styles.arrowIcon} />
          </i>
        </p>
      </li>
      <li className={styles.menuItem}>
        <Link className={styles.menuLink} to="/gear.html">
          Publication
        </Link>
      </li>
      {dataMenuPublication.map((item, index) => (
        <li className={`${styles.menuItem} ${styles.child}`} key={index}>
          <Link className={`${styles.menuLink} ${styles.child}`} to={item.link}>
            {item.name}
          </Link>
        </li>
      ))}
    </ul>
  );
};

const PopupMenu = () => {
  const [appState, { closeDrawer, toggleDrawer }] = useAppContext();
  const { drawer } = appState;
  const isOpen = drawer === 'menu-list';
  const [isOpenModelMenu, setIsOpenModelMenu] = useState(false);
  const [isOpenPublicationMenu, setIsOpenPublicationMenu] = useState(false);
  return (
    <aside
      className={`modal-popup p-0 modal-popup-left ${
        isOpen ? `active active-slide-in-left` : ''
      }`}
    >
      <div className={`${styles.popupBox}`}>
        <div className={styles.popupHeader}>
          <i>
            <CloseIcon className={styles.closeIcon} onClick={closeDrawer} />
          </i>
        </div>
        <div className={styles.popupBody}>
          {!isOpenModelMenu &&
            (!isOpenPublicationMenu && (
              <ul className={styles.menuList}>
                <li
                  className={styles.menuItem}
                  onClick={() => setIsOpenModelMenu(true)}
                >
                  <p className={styles.menuLink}>
                    Toy & Model
                    <i>
                      <RightIcon className={styles.arrowIcon} />
                    </i>
                  </p>
                </li>
                <li className={styles.menuItem}>
                  <Link className={styles.menuLink} to="/training.html">
                    Board Game
                  </Link>
                </li>
                <li className={styles.menuItem}>
                  <Link className={styles.menuLink} to="/trading-card.html">
                    Trading Card
                  </Link>
                </li>
                <li className={styles.menuItem}>
                  <Link className={styles.menuLink} to="/men.html">
                    Game
                  </Link>
                </li>
                <li
                  className={styles.menuItem}
                  onClick={() => setIsOpenPublicationMenu(true)}
                >
                  <p className={styles.menuLink}>
                    Publication
                    <i>
                      <RightIcon className={styles.arrowIcon} />
                    </i>
                  </p>
                </li>
                <li className={styles.menuItem}>
                  <Link className={styles.menuLink} to="/collections.html">
                    Digital File
                  </Link>
                </li>
                <li className={styles.menuItem}>
                  <Link className={styles.menuLink} to="/women.html">
                    Character Goods
                  </Link>
                </li>
                <li className={styles.menuItem}>
                  <Link className={styles.menuLink} to="/promotions.html">
                    ETC
                  </Link>
                </li>
              </ul>
            ))}
          {isOpenModelMenu && (
            <ToyAndModelMenu setIsOpenModelMenu={setIsOpenModelMenu} />
          )}
          {isOpenPublicationMenu && (
            <PublicationMenu
              setIsOpenPublicationMenu={setIsOpenPublicationMenu}
            />
          )}
        </div>
      </div>
    </aside>
  );
};

export default PopupMenu;
