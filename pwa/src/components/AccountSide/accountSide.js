import React from 'react';
import { useTranslation } from 'react-i18next';
import { ChevronLeft, Settings } from 'react-feather';
import { resourceUrl, useHistory, useLocation } from '@magento/venia-drivers';
import { useUserContext } from 'src/layouts/context/user';

import AvatarDefault from 'src/styles/images/avatar_default.png'

const AccountSide = () => {
    const { t } = useTranslation(['common']);
    const history = useHistory();
    const location = useLocation();
    const [{ currentUser }] = useUserContext();

    return (
        <div className='container d-flex justify-content-between align-items-center py-3 size-base'>
            { location.pathname !== '/account' &&
                <div className='btn'>
                    <ChevronLeft
                        size={30}
                        onClick={ () => {
                            history.push(resourceUrl('/account'))
                        }}
                    />
                </div>
            }
            <div className='d-flex align-items-center'>
                <div
                    className='image-circle'
                    style={{
                        backgroundImage: `url(${currentUser.image ? currentUser.image : AvatarDefault})`
                    }}
                />
                <p className='mb-0 ml-3 size-big'>{`${currentUser.firstname} ${currentUser.lastname}`}</p>
            </div>
            <div className='btn'>
                <Settings
                    size={24}
                    onClick={ () => {
                        history.push(resourceUrl('/account/settings'))
                    }}
                />
            </div>
        </div>
    );
}

export default AccountSide;
