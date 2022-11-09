import React, { createContext, useContext, useMemo } from 'react';
import { connect } from 'react-redux';

import actions from './actions';
import * as asyncActions from './asyncActions';
import bindActionCreators from '@magento/peregrine/lib/util/bindActionCreators';

const UserContext = createContext();

const UserContextProvider = props => {
    const { actions, asyncActions, children, userState } = props;

    const userApi = useMemo(
        () => ({
            actions,
            ...asyncActions
        }),
        [actions, asyncActions]
    );

    const contextValue = useMemo(() => [userState, userApi], [
        userApi,
        userState
    ]);

    return (
        <UserContext.Provider value={contextValue}>
            {children}
        </UserContext.Provider>
    );
};

const mapStateToProps = ({ user }) => ({ userState: user });

const mapDispatchToProps = dispatch => ({
    actions: bindActionCreators(actions, dispatch),
    asyncActions: bindActionCreators(asyncActions, dispatch)
});

export default connect(
    mapStateToProps,
    mapDispatchToProps
)(UserContextProvider);

export const useUserContext = () => useContext(UserContext);
