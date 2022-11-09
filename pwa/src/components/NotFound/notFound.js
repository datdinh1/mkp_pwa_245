import React, { useCallback } from 'react';
import { useTranslation } from 'react-i18next';
import defaultClasses from './notFound.css';
import NotFoundImage from 'src/styles/images/notfound.png';
import { Title } from '@magento/venia-ui/lib/components/Head';

const NotFound = props => {
    const { t } = useTranslation(['common']);

    return (
        <>
            <Title>{t('404 Page Not Found')}</Title>
            <div className='container'>
                <div className={defaultClasses.root}>
                    <div className={defaultClasses.content}>
                        <img src={NotFoundImage} alt='not-found' width={100} />
                        <div className='ml-3'>
                            <h2>{t('We can\'t find the page')}</h2>
                            <h4>{t('Unfortunately we can\'t find the page you are looking for.')}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
};

export default NotFound;
