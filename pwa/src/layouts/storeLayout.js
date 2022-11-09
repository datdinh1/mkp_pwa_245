import React from 'react';
import { bool, shape, string } from 'prop-types';
import { useScrollLock } from 'src/hooks/useScrollLock';

import Footer from '../components/Footer';
import { Title } from '@magento/venia-ui/lib/components/Head';
import HeaderStore from '../components/HeaderStore';

const Main = props => {
  const { children, isMasked, pageTitle } = props;

  useScrollLock(isMasked);

  return (
    <main>
      {pageTitle && <Title>{pageTitle}</Title>}
      <div className="bg-white">
        <HeaderStore />
      </div>
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
