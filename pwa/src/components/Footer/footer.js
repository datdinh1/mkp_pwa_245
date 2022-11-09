import React from "react";
import styles from './footer.module.scss'
import CHECKOUT from '../../styles/images/checkout.png'
import FACEBOOK from '../../styles/images/facebook_footer.png'
import YOUTUBE from '../../styles/images/youtube.png'


const Footer = () => {
    return (
        <footer className={styles.footerContainer}>
            <div className='container'>
                <div className={`${styles.footerRow} row py-4`}>
                    <div className={styles.footerMenu}>
                        <h3> Help center </h3>
                        <ul>
                            <li>test1</li>
                            <li>test2</li>
                            <li>test3</li>
                            <li>test4</li>
                        </ul>
                    </div>
                    <div className={styles.footerMenu}>
                        <h3> About Us </h3>
                        <ul className='mb-3'>
                            <li>About Nurse Marketplace</li>
                        </ul>
                        <h3> Contact Us </h3>
                        <ul className='mb-3'>
                            <li>About Nurse Marketplace</li>
                        </ul>
                    </div>
                    <div className={styles.footerMenu}>
                        <div className='mb-5'>
                            <h3> Payment Method </h3>
                            <img src={CHECKOUT} alt='CHECKOUT'/>
                        </div>
                        <div className='mb-5'>
                            <h3> Follow us at </h3>
                            <div>
                                <img src={FACEBOOK} alt='FACEBOOK' className='pr-4'/>
                                <img src={YOUTUBE} alt='YOUTUBE'/>
                            </div>
                            
                        </div>
                    </div>
                    <div className={styles.footerMenu}>
                        <div className='mb-5'>
                            <h3> Subscribe to our newsletter </h3>
                            <div className='row ml-0' >
                                <div className={styles.inputForm}>
                                    <input type='email' placeholder='Email Address'/>
                                </div>
                                <button className={styles.inputButton}>
                                    <span>Apply</span>
                                </button>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </footer>
    )
}

export default Footer