<?php

namespace Wiki\VendorsCoupon\Block\Vendors\Coupon\Edit;

/**
 * Class Form Grid
 * 
 * @category Wiki
 * @package  Wiki_BannerManager
 * @module   BannerManager
 * @author   Wiki Developer Team
 */
class Form extends \Wiki\Vendors\Block\Vendors\Widget\Form\Generic
{

    /**
     * Prepar form edit
     *
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareForm()
    {
        // id common for all form
        $form = $this->_formFactory->create(
            array(
                'data' => array(
                    'id'      => 'edit_form',
                    'action'  => $this->getData('action'),
                    'method'  => 'post',
                    'enctype' => 'multipart/form-data',
                ),
            )
        );

        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
