import React from 'react';
import { bool, shape, string } from 'prop-types';
import { useScrollLock } from 'src/hooks/useScrollLock';

// import Footer from '@magento/venia-ui/lib/components/Footer';
import { Title } from '@magento/venia-ui/lib/components/Head';
import SignInSide from 'src/components/SignInSide';
import SignIn from 'src/components/SignIn';
import Register from 'src/components/Register';
import Header from '../components/Header';
import Footer from '../components/Footer';
import ToggleButtonMenu from '../components/ToggleButtonMenu';

const Main = props => {
  const { children, isMasked, pageTitle } = props;

  useScrollLock(isMasked);

  return (
    <main>
      {pageTitle && <Title>{pageTitle}</Title>}
      <div
        className="bg-white"
        style={{ position: 'sticky', top: 0, zIndex: 2 }}
      >
        <SignInSide />
        <Header />
      </div>
      <SignIn />
      <Register />
      <ToggleButtonMenu />
      <div className="page" style={{ paddingBottom: '30px' }}>
        {children}
      </div>
      {/* <Footer /> */}
      <Footer />
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
