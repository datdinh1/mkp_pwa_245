import React from 'react';
import styles from './table.module.scss';
import { Link } from 'react-router-dom';
import { ChevronRight as RightIcon } from 'react-feather';
const Table = ({ data }) => {
  return (
    <div className={styles.tableContainer}>
      <div className={styles.tableBox}>
        <div className={styles.tableHeader}>
          <h3 className={`${styles.tableTitle}`}>{data.name}</h3>
          <Link to="#" className={`${styles.tableLink}`}>
            See more <RightIcon className={styles.icon} />
          </Link>
        </div>
        <div className={styles.listItem}>
          {data.children &&
            data.children.length &&
            data.children.map((item, index) => (
              <Link
                to={`${item.url_path}${item.url_suffix}`}
                className={styles.item}
                key={item.id}
              >
                <div className={styles.itemImage}>
                  <img
                    src={item.image}
                    alt={item.name}
                    className={styles.image}
                    loading="lazy"
                  />
                </div>
                <div className={styles.itemName}>
                  <p className={styles.itemText}>{item.name}</p>
                </div>
              </Link>
            ))}
        </div>
      </div>
    </div>
  );
};

export default Table;
