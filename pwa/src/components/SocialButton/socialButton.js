import React from 'react';
import SocialLogin from 'react-social-login';

class SocialButton extends React.Component {
    render() {
        const { children, triggerLogin, ...props } = this.props;
        const handleClick = event => {
            event.preventDefault();
            triggerLogin();
        }
        return (
            <button onClick={handleClick} {...props}>
                {children}
            </button>
        );
    }
}

export default SocialLogin(SocialButton);
