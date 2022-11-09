import React from 'react'
import { useState } from 'react'
import ListDeliveryAddress from '../../components/ListDeliveryAddress/listDeliveryAddress'
import styles from './deliveryAddress.module.scss'
const DeliveryAddress = () => {
  return (
    <div  className={styles.deliveryAddressContainer}>
        <div className='container'>
            <div className={styles.deliveryAddressBody}>
                 <section className={styles.deliveryAddressList}><ListDeliveryAddress/></section>
            </div>
        </div>
    </div>
  )
}

export default DeliveryAddress