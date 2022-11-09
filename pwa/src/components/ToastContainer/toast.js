import React from 'react';
import { bool, func, number, object, oneOf, string } from 'prop-types';
import defaultClasses from './toast.scss';
import { mergeClasses } from '@magento/venia-ui/lib/classify';
import { useTranslation } from 'react-i18next';

const Toast = props => {
    const { t } = useTranslation(['common']);
    const {
        actionText,
        dismissable,
        icon,
        message,
        onAction,
        handleAction,
        onDismiss,
        handleDismiss,
        type
    } = props;

    const classes = mergeClasses(defaultClasses, {});

    const iconElement = icon ? <>{icon}</> : null;

    const controls =
        onDismiss || dismissable ? (
            <button className={classes.dismissButton} onClick={handleDismiss}>
                {t('Cancel')}
            </button>
        ) : null;

    const actions = onAction ? (
        <button className={classes[`${type}Button`]} onClick={handleAction}>
            {actionText}
        </button>
    ) : null;

    return (
        <div className={classes[`${type}Toast`]}>
            <div className='d-flex justify-content-center align-items-center'>
                <span className={classes.icon}>{iconElement}</span>
                <div className={classes.message}>{message}</div>
            </div>
            <div className='d-flex justify-content-center mt-3 w-75'>
                {actions}
                {controls}
            </div>
        </div>
    );
};

Toast.propTypes = {
    actionText: string,
    dismissable: bool,
    icon: object,
    id: number,
    message: string.isRequired,
    onAction: func,
    onDismiss: func,
    handleAction: func,
    handleDismiss: func,
    type: oneOf(['info', 'warning', 'error']).isRequired
};

export default Toast;
