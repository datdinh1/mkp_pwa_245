import React,{ useState } from 'react'
import styles from './descriptionProduct.module.scss'
import {ChevronDown as DownIcon} from 'react-feather'

const DescriptionProduct = () => {
  const [openDescription, setOpenDescription] = useState(false)
  return (
    <div className={`${styles.descriptionProductContainer}`}>
       <div className={styles.descriptionProductHeader} onClick={() => setOpenDescription(prev=> !prev)}>
        <p className={styles.descriptionProductText}>Product details</p>
        <i><DownIcon className={`${styles.iconDown}  ${openDescription && styles.active}`}/></i>
       </div>
       <div className={`${styles.descriptionProductContent} ${openDescription && styles.active}`}>
        <div className={styles.contentTop}>
          <div className={styles.content}>
            <p className={styles.contentTitle}>Product category</p>
            <p className={styles.contentText}>Board Game, Toy & Model</p>
          </div> 
          <div className={styles.content}>
            <p className={styles.contentTitle}>Condition</p>
            <p className={styles.contentText}>New</p>
          </div> 
          <div className={styles.content}>
            <p className={styles.contentTitle}>Brand</p>
            <p className={styles.contentText}>Kotobukiya</p>
          </div> 
          <div className={styles.content}>
            <p className={styles.contentTitle}>Sex</p>
            <p className={styles.contentText}>Male</p>
          </div> 
          <div className={styles.content}>
            <p className={styles.contentTitle}>Age</p>
            <p className={styles.contentText}>0-6</p>
          </div> 
          <div className={styles.content}>
            <p className={styles.contentTitle}>Product weight</p>
            <p className={styles.contentText}>12 Unknown</p>
          </div> 
          <div className={styles.content}>
            <p className={styles.contentTitle}>parcel size</p>
            <p className={styles.contentText}>12 x 3 x 2 Unknown</p>
          </div> 
        </div>
        <div className={styles.contentBottom}>
        <div className={styles.description}>
            <p className={styles.descriptionTitle}>Description</p>
            <p className={styles.descriptionText}>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like) .There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>
          </div> 
        </div>
       </div>
    </div>
  )
}

export default DescriptionProduct