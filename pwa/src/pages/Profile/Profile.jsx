import { useAppContext } from '@magento/peregrine/lib/context/app';
import combine from '@magento/venia-ui/lib/util/combineValidators';
import {
  hasLengthAtLeast,
  isRequired,
  validateConfirmPassword,
  validatePassword
} from '@magento/venia-ui/lib/util/formValidators';
import { Form, Select } from 'informed';
import React, { useEffect, useRef, useState } from 'react';
import {
  Camera as CameraIcon,
  ChevronLeft as LeftIcon,
  Edit3 as EditIcon,
  Lock as LockIcon
} from 'react-feather';
import { useTranslation } from 'react-i18next';
import { useUserContext } from 'src/layouts/context/user';
import btnLoading from 'src/styles/images/btnLoading.svg';
import TextInput from '../../components/TextInput';
import AVATAR from '../../styles/images/avatar.jpg';
import styles from './profile.module.scss';
import UPDATE_CUSTOMER from './updateCustomer.graphql';
import UPDATE_PASSWORD from './updatePassword.graphql';
import { useProfile } from './useProfile';

const Profile = () => {
  const { t } = useTranslation(['profile']);
  const [appState, { closeDrawer, toggleDrawer }] = useAppContext();
  const { drawer } = appState;
  const isOpen = drawer === 'change-password';

  const [{ isSignedIn, currentUser }, { signOut }] = useUserContext();

  const [image, setImage] = useState(AVATAR);

  useEffect(() => {
    return () => {
      URL.revokeObjectURL(image);
    };
  }, [image]);

  const talonProps = useProfile({
    updateCustomerInfo: UPDATE_CUSTOMER,
    updatePasswordInfo: UPDATE_PASSWORD
  });

  const {
    handleUpdateInfo,
    isEdit,
    setIsEdit,
    loadingUpdateInfo,
    handleUpdatePassword,
    loadingPassword
  } = talonProps;

  useEffect(() => {
    window.scrollTo(0, 0);
  }, []);

  const formPasswordRef = useRef();
  const handleSubmitPassword = async data => {
    const result = await handleUpdatePassword(data);
    if (result) {
      formPasswordRef.current.formApi.reset();
    }
  };

  return isSignedIn && currentUser && currentUser.firstname ? (
    <div className={styles.profileContainer}>
      <div className="container">
        <div className={styles.profileBody}>
          <section className={styles.profileFormContainer}>
            <div className={styles.profileTitle}>
              <h1 className={styles.titleText}>{t('Personal Information')}</h1>
            </div>
            <Form onSubmit={handleUpdateInfo}>
              <div className={styles.inputImage}>
                <div className={styles.avatar}>
                  <img
                    src={
                      typeof image === 'object'
                        ? URL.createObjectURL(image)
                        : image
                    }
                    alt="avatar"
                    loading="lazy"
                    className={styles.avatarImg}
                  />
                  <input
                    type="file"
                    id="avatar-input"
                    hidden
                    onChange={e => setImage(e.target.files[0])}
                    multiple={false}
                    accept="image/jpeg,image/png"
                  />
                  <label
                    htmlFor="avatar-input"
                    className={styles.avatarLabel}
                    hidden={!isEdit}
                  >
                    <i>
                      <CameraIcon className={styles.avatarIcon} />
                    </i>
                  </label>
                </div>
              </div>
              <div className={styles.inputField}>
                <label className={styles.labelField}>
                  {t('First Name')}{' '}
                  <span className={styles.fieldRequired}>*</span>
                </label>
                <div className={styles.input}>
                  <TextInput
                    placeholder={t('First Name')}
                    autoComplete="firstname"
                    field="firstname"
                    validate={combine([isRequired, [hasLengthAtLeast, 2]])}
                    validateOnBlur={true}
                    initialValue={currentUser.firstname}
                    disabled={!isEdit && 'disabled'}
                  />
                </div>
              </div>
              <div className={styles.inputField}>
                <label className={styles.labelField}>
                  {t('Last Name')}{' '}
                  <span className={styles.fieldRequired}>*</span>
                </label>
                <div className={styles.input}>
                  <TextInput
                    placeholder={t('Last Name')}
                    autoComplete="lastname"
                    field="lastname"
                    validate={combine([isRequired])}
                    validateOnBlur={true}
                    initialValue={currentUser.lastname}
                    disabled={!isEdit && 'disabled'}
                  />
                </div>
              </div>
              <div className={styles.inputField}>
                <label className={styles.labelField}>{t('Username')}</label>
                <div className={styles.input}>
                  <TextInput
                    placeholder={t('Username')}
                    autoComplete="username"
                    field="username"
                    validate={combine([isRequired])}
                    validateOnBlur={true}
                    initialValue={currentUser.email}
                    disabled={'disabled'}
                  />
                </div>
              </div>
              <div className={styles.inputField}>
                <label className={styles.labelField}>{t('Birthday')}</label>
                <div className={`${styles.input} ${styles.date}`}>
                  <TextInput
                    placeholder={t('Birthday')}
                    autoComplete="date_of_birth"
                    field="date_of_birth"
                    type="date"
                    initialValue={currentUser.date_of_birth}
                    validateOnBlur={true}
                    disabled={!isEdit && 'disabled'}
                    max={`${new Date().toISOString().split('T')[0]}`}
                  />
                </div>
              </div>
              <div className={styles.inputField}>
                <label className={styles.labelField}>{t('Sex')}</label>
                <div className={styles.input}>
                  <Select
                    name="gender"
                    label="sex"
                    initialValue={currentUser.gender || 0}
                    field="gender"
                    disabled={!isEdit && 'disabled'}
                  >
                    <option value={0}>{t('Not Specific')}</option>
                    <option value={1}>{t('Male')}</option>
                    <option value={2}>{t('Female')}</option>
                  </Select>
                </div>
              </div>
              <div className={styles.buttonArea}>
                <button
                  type="button"
                  className={styles.buttonChangePassword}
                  onClick={() => {
                    toggleDrawer('change-password');
                  }}
                >
                  <i>
                    <LockIcon className={styles.buttonIcon} />
                  </i>
                  {t('Change Password')}
                </button>
                <button
                  disabled={loadingUpdateInfo && true}
                  type="submit"
                  className={`${styles.buttonSubmit} ${!isEdit &&
                    styles.disable}`}
                >
                  {loadingUpdateInfo && (
                    <img
                      className="mr-3"
                      width={15}
                      src={btnLoading}
                      alt="loading"
                      loading="lazy"
                    />
                  )}
                  {t('Confirm')}
                </button>
                <button
                  type="button"
                  className={`${styles.buttonSubmit} ${isEdit &&
                    styles.disable}`}
                  onClick={() => setIsEdit(true)}
                >
                  <i>
                    <EditIcon className={styles.buttonIcon} />
                  </i>{' '}
                  {t('edit')}
                </button>
              </div>
            </Form>
          </section>

          <section className={styles.changePasswordContainer}>
            <aside
              className={`modal-popup p-0 ${
                isOpen ? `active ${styles.slideInRight}` : ''
              } ${styles.modalContainer}`}
            >
              <div className={`${styles.changePasswordBox}`}>
                <div className={styles.boxHeader}>
                  <i>
                    <LeftIcon
                      className={styles.iconChangePassword}
                      onClick={closeDrawer}
                    />
                  </i>
                  <h1 className={styles.titleChangePassword}>
                    {t('Change Password')}
                  </h1>
                </div>
                <div className={styles.boxContent}>
                  <Form ref={formPasswordRef} onSubmit={handleSubmitPassword}>
                    <div className={styles.inputChangePasswordField}>
                      <label className={styles.labelChangePasswordField}>
                        {t('Current Password')}{' '}
                        <span className={styles.fieldRequired}>*</span>
                      </label>
                      <div className={styles.inputChangePassword}>
                        <TextInput
                          placeholder="Current Password"
                          autoComplete="currentPassword"
                          field="currentPassword"
                          type="password"
                          validate={combine([isRequired])}
                          validateOnBlur={true}
                        />
                      </div>
                    </div>
                    <div className={styles.inputChangePasswordField}>
                      <label className={styles.labelChangePasswordField}>
                        {t('Password')}{' '}
                        <span className={styles.fieldRequired}>*</span>
                      </label>
                      <div className={styles.inputChangePassword}>
                        <TextInput
                          placeholder="Password"
                          autoComplete="password"
                          field="password"
                          type="password"
                          validate={combine([
                            isRequired,
                            [hasLengthAtLeast, 8],
                            validatePassword
                          ])}
                          validateOnBlur={true}
                        />
                      </div>
                    </div>
                    <div className={styles.inputChangePasswordField}>
                      <label className={styles.labelChangePasswordField}>
                        {t('Retype Password')}{' '}
                        <span className={styles.fieldRequired}>*</span>
                      </label>
                      <div className={styles.inputChangePassword}>
                        <TextInput
                          placeholder="Retype Password"
                          autoComplete="retypepassword"
                          field="retypepassword"
                          type="password"
                          validate={combine([
                            isRequired,
                            validateConfirmPassword
                          ])}
                          validateOnBlur={true}
                        />
                      </div>
                    </div>
                    <div className={styles.buttonArea}>
                      <button
                        type="submit"
                        className={`${styles.buttonSubmit}`}
                        disabled={loadingPassword && true}
                        onClick={e => {
                          handleClear(e);
                        }}
                      >
                        {loadingPassword && (
                          <img
                            className="mr-3"
                            width={15}
                            src={btnLoading}
                            alt="loading"
                            loading="lazy"
                          />
                        )}
                        {t('Confirm')}
                      </button>
                    </div>
                  </Form>
                </div>
              </div>
            </aside>
          </section>
        </div>
      </div>
    </div>
  ) : (
    <></>
  );
};

export default Profile;
