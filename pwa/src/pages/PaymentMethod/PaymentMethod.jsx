import combine from '@magento/venia-ui/lib/util/combineValidators';
import { hasLengthExactly, isRequired } from '@magento/venia-ui/lib/util/formValidators';
import { Form, Select } from 'informed';
import React, { useEffect } from 'react';
import { useTranslation } from 'react-i18next';
import AddPaymentMethod from '../../components/AddPaymentMethod/addPaymentMethod';
import CheckboxCustom from '../../components/CheckboxCustom';
import TextInput from '../../components/TextInput';
import styles from './paymentMethod.module.scss';
import { usePayment } from './usePayment';

const PaymentMethod = () => {
  const { t } = useTranslation(['paymentMethod']);

  const {handleCreateBankAccount, handleCreateCard} = usePayment()

  useEffect(() => {
    window.scrollTo(0,0)
  }, [])

  return (
    <div className={styles.paymentMethodContainer}>
      <div className='container'>
        <div className={styles.paymentMethodBody}>
          <div className={styles.paymentMethodTitle}>
            <h1 className={styles.titleText}>{t('Payment Method')}</h1>
          </div>
          <section className={styles.addPaymentMethod}>
            <AddPaymentMethod title='My Credit Card' namePopup='Add A New Credit Card' titlePopup='Add New Card'> 
              <div className={styles.formContainer}>
                <Form onSubmit={handleCreateCard}>
                  <div className={`${styles.inputField} ${styles.field1}`}>
                    <div className={styles.input}>
                      <TextInput
                            placeholder={t('Card Number')}
                            autoComplete='cardnumber'
                            field='cardnumber'
                            validate={combine([isRequired, [hasLengthExactly,16]])}
                            validateOnBlur={true}
                        />
                    </div>
                  </div>
                  <div className={`${styles.inputField} ${styles.field1}`}>
                    <div className={styles.input}>
                      <TextInput
                            placeholder={t('Name On Card')}
                            autoComplete='nameoncard'
                            field='nameoncard'
                            validate={combine([isRequired])}
                            validateOnBlur={true}
                        />
                    </div>
                  </div>
                  <div className={`${styles.inputField} ${styles.field2}`}>
                    <div className={styles.inputGroup}>
                      <div className={styles.input}>
                        <Select name="month" label="month" field='month' initialValue='month' validate={combine([isRequired])}>
                          <option value="month" disabled>{t('Month')}</option>
                          {Array(12).fill(0).map((item, index) => (
                            <option value={index + 1} key={index}>{index + 1}</option>
                          ))}
                        </Select>
                      </div>
                      <div className={styles.input}>
                        <Select name="year" label="year" field='year' initialValue='year' validate={combine([isRequired])}>
                            <option value="year" disabled>{t('Year')}</option>
                            {Array(25).fill(0).map((item, index) => (
                              <option value={index + 1990} key={index}>{index + 1990}</option>
                            ))}
                        </Select>
                      </div>
                    </div>
                    <div className={`${styles.input} ${styles.right}`}>
                      <TextInput
                        placeholder={t('CVV Code')}
                        autoComplete='cvvcode'
                        field='cvvcode'
                        type='password'
                        validate={combine([isRequired, [hasLengthExactly,4]])}
                        validateOnBlur={true}
                      />
                    </div>
                  </div>
                  <div className={`${styles.inputField} ${styles.field3}`}>
                    <p className={styles.label}>{t('Set As Default')}</p>
                    <CheckboxCustom id={1}/>
                  </div>
                  <div className={styles.buttonArea}>
                    <button className={styles.buttonSubmit} type="submit">{t('Confirm')}</button>
                  </div>
                </Form>
              </div>
            </AddPaymentMethod>
          </section>
          <hr className={styles.divider}/>


          <section className={styles.addPaymentMethod}>
            <AddPaymentMethod title='My Credit Card' namePopup='Add Bank Account' titlePopup='Add Bank Account'>
            <div className={styles.formContainer}>
                <Form onSubmit={handleCreateBankAccount}>
                  <div className={`${styles.inputField} ${styles.field1}`}>
                    <div className={styles.input}>
                      <TextInput
                            placeholder={t('Name-surname Page Of The Account Book')}
                            autoComplete='accountbook'
                            field='accountbook'
                            validate={combine([isRequired])}
                            validateOnBlur={true}
                        />
                    </div>
                  </div>
                  <div className={`${styles.inputField} ${styles.field1}`}>
                    <div className={styles.input}>
                      <TextInput
                            placeholder={t('Account Number')}
                            autoComplete='accountnumber'
                            field='accountnumber'
                            validate={combine([isRequired])}
                            validateOnBlur={true}
                        />
                    </div>
                  </div>
                  <div className={`${styles.inputField} ${styles.field1}`}>
                    <div className={styles.input}>
                      <Select name="bank" label="bank" field='bank' initialValue='bank' validate={combine([isRequired])}>
                        <option value="bank" disabled>{t('Select Bank')}</option>
                        {Array(12).fill(0).map((item, index) => (
                          <option value={index + 1} key={index}>{index + 1}</option>
                        ))}
                      </Select>
                    </div>
                  </div>
                  <div className={`${styles.inputField} ${styles.field3}`}>
                    <p className={styles.label}>{t('Set As Default')}</p>
                    <CheckboxCustom id={2}/>
                  </div>
                  <div className={styles.buttonArea}>
                    <button className={styles.buttonSubmit} type="submit">{t('Confirm')}</button>
                  </div>
                </Form>
              </div>
            </AddPaymentMethod>
          </section> 
        </div>
      </div>
    </div>
  )
}

export default PaymentMethod