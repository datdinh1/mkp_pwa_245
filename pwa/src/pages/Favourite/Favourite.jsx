import React, { useEffect } from 'react'
import ListProductFavourite from '../../components/ListProductFavourite/listProductFavourite'
import styles from './favourite.module.scss'

const Favourite = () => {
  useEffect(() => {
    window.scrollTo(0,0)
  }, [])
  return (
    <div className={styles.favouriteContainer}>
        <div className='container'>
            <div className={styles.favouriteBody}>
              <section className={styles.favouriteListProduct}><ListProductFavourite/></section>
            </div>
        </div>
    </div>
  )
}

export default Favourite