import React from 'react';
import { bool, shape, string } from 'prop-types';
import { resourceUrl, useHistory } from '@magento/venia-drivers';
import { useScrollLock } from 'src/hooks/useScrollLock';
import { useAppContext } from '@magento/peregrine/lib/context/app';
import { useUserContext } from 'src/layouts/context/user';

import { Title } from '@magento/venia-ui/lib/components/Head';
import AccountSide from 'src/components/AccountSide';
import Header from '../components/Header';

const Main = props => {
  const { children, isMasked, pageTitle } = props;
  const history = useHistory();
  const [, { toggleDrawer }] = useAppContext();
  const [{ isSignedIn }] = useUserContext();

  useScrollLock(isMasked);

  if (!isSignedIn) {
    toggleDrawer('sign-in');
    history.push(resourceUrl('/'));
  }

  return (
    <main>
      {pageTitle && <Title>{pageTitle}</Title>}
      <div
        className="bg-white"
        style={{ position: 'sticky', top: 0, zIndex: 1 }}
      >
        <AccountSide />
        <Header />
      </div>
      <div className="page" style={{ paddingBottom: '30px' }}>
        {children}
      </div>
    </main>
  );
};

export default Main;

Main.propTypes = {
  classes: shape({
    page: string,
    page_masked: string,
    root: string,
    root_masked: string
  }),
  isMasked: bool
};
