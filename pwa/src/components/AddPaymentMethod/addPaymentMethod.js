import { useAppContext } from '@magento/peregrine/lib/context/app';
import React from 'react';
import { ChevronLeft as LeftIcon } from 'react-feather';
import { useTranslation } from 'react-i18next';
import CREDIT_CARD from '../../styles/images/credit_card.png';
import styles from './addPaymentMethod.module.scss';

const AddPaymentMethod = ({title, namePopup, titlePopup,children}) => {
  const { t } = useTranslation(['paymentMethod']);
  const popup = namePopup.toLowerCase().trim().replace(/[^\w\s-]/g, '').replace(/[\s_-]+/g, '-').replace(/^-+|-+$/g, '');
  const [appState, { closeDrawer, toggleDrawer }] = useAppContext();
  const { drawer } = appState;
  const isOpen = drawer === popup;


  return (
    <div className={styles.addPaymentMethodContainer}>
      <div className={styles.left}>
        <h5 className={styles.title}>{t(`${title}`)}</h5>
      </div>
      <div className={styles.right} onClick={()=>toggleDrawer(popup)}>
        <div className={styles.imagePopup}>
          <img src={CREDIT_CARD} alt='credit card' loading='lazy' className={styles.popupImg}/>
        </div>
        <h6 className={styles.namePopup}>+ {t(`${namePopup}`)}</h6>
      </div>
      <aside className={`modal-popup p-0 modal-popup-right ${isOpen ? `active active-slide-in-right` : ""}`}>
        <div className={`${styles.popupBox}`}>
          <div className={styles.popupHeader}>
            <i><LeftIcon className={styles.closeIcon} onClick={closeDrawer}/></i>
            <h1 className={styles.titlePopup}>{t(`${titlePopup}`)}</h1>
          </div>
          {children}
        </div>
      </aside>
    </div>
  )
}

export default AddPaymentMethod