import React from 'react';
import ToggleMobbile from './ToggleMobile/toggleMobbile';
import TogglePc from './TogglePc/togglePc';

const ToggleButtonMenu = () => {
  return (
    <div
      style={{
        position: 'fixed',
        bottom: 0,
        left: 0,
        zIndex: 4
      }}
    >
      <TogglePc />
      <ToggleMobbile />
    </div>
  );
};

export default ToggleButtonMenu;
