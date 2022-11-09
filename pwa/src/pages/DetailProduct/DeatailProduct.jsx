import React, { useEffect } from 'react'
import InfoProduct from '../../components/InfoProduct'
import styles from './detailProduct.module.scss'

const DeatailProduct = () => {
  useEffect(() => {
    window.scrollTo(0,0)
  }, [])
  
  return (
    <div className={styles.detailProductContainer}>
      <div className='container'>
        <section><InfoProduct/></section>
      </div>
    </div>
  )
}

export default DeatailProduct