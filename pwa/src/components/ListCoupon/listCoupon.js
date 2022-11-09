import { isRequired } from '@magento/venia-ui/lib/util/formValidators';
import { Form } from 'informed';
import React, { useEffect, useRef, useState } from 'react';
import { useTranslation } from 'react-i18next';
import { Link } from 'react-router-dom';
import DataNull from '../DataNull';
import TextInput from '../TextInput';
import styles from './listCoupon.module.scss';

const ListCoupon = () => {
    const { t } = useTranslation('coupon');

    const [isTabChoose, setIsTabChoose] = useState({
        all: true,
        mkp:false,
        coupon: false
    })

    const [isOpenDiscountCoupon, setIsOpenDiscountCoupon] = useState(false)

    const FormSearchRef = useRef(null)

    const handleChangeTab = ({type}) => {
        switch (type) {
            case 'ALL':
                setIsTabChoose({
                    all: true,
                    mkp:false,
                    coupon: false
                })
                break;
                case 'MKP':
                    setIsTabChoose({
                        all: false,
                        mkp:true,
                        coupon: false
                    })
                    break;
                    case 'COUPON':
                        setIsTabChoose({
                            all: false,
                            mkp:false,
                            coupon: true
                        })
                    break;
            default:
                break;
        }
    }

    useEffect(() => {
        function handleClickOutside(event) {
          if (FormSearchRef.current && !FormSearchRef.current.contains(event.target)) {
            setIsOpenDiscountCoupon(false)
          }else{

          }
        }
        // Bind the event listener
        document.addEventListener("mousedown", handleClickOutside);

        return () => {
          // Unbind the event listener on clean up
          document.removeEventListener("mousedown", handleClickOutside);
        };
      }, [FormSearchRef]);

      const handleSubmitCode = ({code}) => {
        console.log(code)
      }

    return (
        <div className={styles.listCouponContainer}>
            {/* TITLE */}
            <div className={styles.listCouponTitle}>
                <h1 className={styles.listCouponTitleText}>{t('My Coupons')}</h1>
            </div>
            <div className={styles.listCouponWishListContainer}>
                {/* LIST TAB */}
                <div className={styles.wishListTab}>
                    <button onClick={()=>handleChangeTab({type:'ALL'})} className={`${styles.tabButton} ${isTabChoose.all === true && styles.active}`}>{t('All')}</button>
                    <button onClick={()=>handleChangeTab({type:'MKP'})} className={`${styles.tabButton} ${isTabChoose.mkp === true  && styles.active}`}>{t('MKP Coupon')}</button>
                    <button onClick={()=>handleChangeTab({type:'COUPON'})} className={`${styles.tabButton} ${isTabChoose.coupon === true && styles.active}`}>{t('Coupon Shop')}</button>
                </div>
                {/* LIST COUPON CHECKOUT */}
                <div className={styles.wishListCheckout}>
                    <div className={styles.checkoutBox}>
                        <div className={styles.checkoutButton} onClick={()=>setIsOpenDiscountCoupon(prev => !prev)}>
                            <span className={`${styles.checkoutIcon} material-symbols-outlined`}>
                                fit_screen
                            </span> 
                            <p className={styles.checkoutCouponText}>{t('Enter A Discount Coupon')}</p>
                        </div>
                        {isOpenDiscountCoupon &&(
                            <div ref={FormSearchRef}>
                                <Form onSubmit={handleSubmitCode} className={styles.checkoutForm} >
                                    <div className={`${styles.inputcodeBox} mr-4`}>
                                        <TextInput
                                            placeholder='Enter a code'
                                            autoComplete='off'
                                            field='code'
                                            validate={isRequired}
                                            validateOnBlur={true}
                                        />
                                    </div>
                                    <button
                                        className={`${styles.buttonConfirm} button button-main w-full`}
                                        type='submit'
                                        // disabled={(isChecked === false || isBusy || loading === true) && true}
                                    > 
                                        {t('Confirm')}
                                    </button>
                                </Form>
                            </div>
                            
                        )}
                       
                    </div>
                    <div className={styles.checkoutBox}>
                        <span className={`${styles.checkoutIcon} material-symbols-outlined`}>
                            confirmation_number
                        </span> 
                        <Link to="/coupon" className={styles.collectCouponLink}>{t('Collect Discount Coupons')}</Link>
                    </div>
                </div>

                {isTabChoose.all && (
                    // LIST COUPON 
                    <div className={styles.wishListItem}>
                        {Array(3).fill(0).map((item,index)=>(
                            <div className={styles.item} key={index}>
                                <div className={styles.itemTop}>
                                    <div className={styles.itemLeft}>
                                        <div className={styles.itemLeftImage}>
                                            <img className={styles.itemLeftImg} src='https://i0.wp.com/eltallerdehector.com/wp-content/uploads/2022/07/one-piece-luffy-png.png?resize=800%2C800&ssl=1' alt='' loading='lazy'/>
                                        </div>
                                        <p className={styles.itemLeftName}>Luffy Shop</p>
                                    </div>
                                    <div className={styles.itemRight}>
                                        <div className={styles.itemRightTag}>
                                            <span>MALL</span>
                                        </div>
                                        <div className={styles.itemRightConTent}>
                                            <h5 className={styles.contentTitle}>ส่วนลด 10% ขั้นตํ่า 1000</h5>
                                            <p className={styles.contentDate}>{`${t('Valid to date')}: 10-10-2022`}</p>
                                        </div>
                                    </div>
                                </div>

                                <div className={styles.itemBottom}>
                                    <div className={styles.itemUse}>
                                        <Link to='/cart' className={styles.linkUse}>{t('Use')}</Link>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                )}

                {isTabChoose.mkp && (
                    // LIST COUPON 
                    <div className={styles.wishListItem}>
                        {Array(5).fill(0).map((item,index)=>(
                            <div className={styles.item} key={index}>
                                <div className={styles.itemTop}>
                                    <div className={styles.itemLeft}>
                                        <div className={styles.itemLeftImage}>
                                            <img className={styles.itemLeftImg} src='https://i0.wp.com/eltallerdehector.com/wp-content/uploads/2022/07/one-piece-luffy-png.png?resize=800%2C800&ssl=1' alt='' loading='lazy'/>
                                        </div>
                                        <p className={styles.itemLeftName}>Luffy Shop</p>
                                    </div>
                                    <div className={styles.itemRight}>
                                        <div className={styles.itemRightTag}>
                                            <span>MALL</span>
                                        </div>
                                        <div className={styles.itemRightConTent}>
                                            <h5 className={styles.contentTitle}>ส่วนลด 10% ขั้นตํ่า 1000</h5>
                                            <p className={styles.contentDate}>{`${t('Valid to date')}: 10-10-2022`}</p>
                                        </div>
                                    </div>
                                </div>

                                <div className={styles.itemBottom}>
                                    <div className={styles.itemUse}>
                                        <Link to='/cart' className={styles.linkUse}>{t('Use')}</Link>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                )}

                {isTabChoose.coupon && (
                   <div className={styles.couponNull}><DataNull notice="Try collect coupons from other pages"/></div>
                )}
            </div>
        </div>
    )
}

export default ListCoupon