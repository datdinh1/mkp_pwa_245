import React, { useEffect } from 'react';
import ListProduct from '../../components/ListProduct';
import styles from './store.module.scss';

const Store = () => {
  useEffect(() => {
    window.scrollTo(0, 0);
  }, []);
  return (
    <div className={styles.storeContainer}>
      <div className="container">
        <section className={styles.storeListProduct}>
          <ListProduct
            title="All Products"
            link="/"
            typeTitle="text"
            isButton={true}
          />
        </section>
      </div>
    </div>
  );
};

export default Store;
