import React, { useEffect } from 'react'
import ListFollower from '../../components/ListFollower/listFollower'
import styles from './follower.module.scss'

const Follower = () => {
  useEffect(() => {
    window.scrollTo(0,0)
  }, [])

  return (
    <div className={styles.followerContainer}>
      <div className='container'>
        <div className={styles.followerBody}>
          <section className={styles.followerListFollower}><ListFollower/></section>
        </div>
      </div>
    </div>
  )
}

export default Follower