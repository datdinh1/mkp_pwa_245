import React, { useEffect, useRef } from 'react';
import { instanceOf, number, oneOfType, shape, string, bool } from 'prop-types';
import { asField } from 'informed';
import { compose } from 'redux';
import DatePicker from 'react-datepicker';
import 'react-datepicker/dist/react-datepicker.css';

const DatePickerInput = props => {
    const {
        fieldState,
        fieldApi,
        onValueChange,
        allowManualInput = false,
        ...rest
    } = props;

    const pickerRef = useRef(null);
    useEffect(() => {
        if (!allowManualInput && pickerRef.current !== null) {
            pickerRef.current.input.readOnly = true;
            pickerRef.current.input.style.pointerEvents = 'auto';
        }
    }, [pickerRef, allowManualInput]);

    const { asyncError, error } = fieldState;
    const errorMessage = error || asyncError;

    const { setValue } = fieldApi;

    return (
        <>
            <DatePicker
                {...rest}
                ref={pickerRef}
                selected={fieldState.value}
                onChange={date => {
                    setValue(date);
                    onValueChange && onValueChange(date);
                }}
            />
            {errorMessage && <p className="message-error">{errorMessage}</p>}
        </>
    );
};

DatePickerInput.propTypes = {
    allowManualInput: bool,
    fieldState: shape({
        value: oneOfType([string, number, instanceOf(Date)])
    })
};

export default compose(asField)(DatePickerInput);
