import React from 'react'
import styles from './header.module.scss'
import HeaderMobile from './HeaderMobile/headerMobile'
import HeaderPC from './HeaderPC/headerPC'

const Header = () => {
  return (
    <header className={styles.headerContainer}>
      <div className='container'> 
        <HeaderPC/>
        <HeaderMobile/>
      </div>
    </header>
  )
}

export default Header