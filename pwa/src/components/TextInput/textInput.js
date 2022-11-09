import React, { Component, Fragment } from 'react';
import { node, shape, string } from 'prop-types';
import { BasicText, asField } from 'informed';
import { compose } from 'redux';

import classify from '@magento/venia-ui/lib/classify';
import { Message } from '@magento/venia-ui/lib/components/Field';

export class TextInput extends Component {
    static propTypes = {
        after: node,
        before: node,
        classes: shape({
            input: string
        }),
        fieldState: shape({
            value: string
        }),
        message: node
    };

    render() {
        const {
            after,
            before,
            classes,
            fieldState,
            message,
            ...rest
        } = this.props;

        const { asyncError, error } = fieldState;
        const errorMessage = error || asyncError;

        return (
            <Fragment>
                <BasicText
                    {...rest}
                    fieldState={fieldState}
                    className={classes.input}
                />
                {errorMessage && <p className="message-error">{errorMessage}</p>}
            </Fragment>
        );
    }
}

export default compose(
    classify(),
    asField
)(TextInput);
