<?php

namespace Wiki\SmsNotification\Block\Adminhtml\News\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
use Magento\Cms\Model\Wysiwyg\Config;
use Wiki\SmsNotification\Model\System\Config\Status;
use Wiki\SmsNotification\Model\System\Config\Objuser;

class Info extends Generic implements TabInterface
{
    /**
     * @var \Magento\Cms\Model\Wysiwyg\Config
     */
    protected $_wysiwygConfig;

    /**
     * @var \Wiki\SmsNotification\Model\Config\Status
     */
    protected $_newsStatus;

    protected $galleryFactory;

   /**
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param Config $wysiwygConfig
     * @param Status $newsStatus
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        Config $wysiwygConfig,
        Status $newsStatus,
        Objuser $newsObjuser,
        array $data = []
    ) {
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_newsStatus = $newsStatus;
        $this->_newsObjuser = $newsObjuser;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form fields
     *
     * @return \Magento\Backend\Block\Widget\Form
     */
    protected function _prepareForm()
    {
       /** @var $model \Wiki\SmsNotification\Model\News */
        $model = $this->_coreRegistry->registry('wiki_smsnotification');
        $data = $model->getData();
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $this->setForm($form);
        //  $form->setHtmlIdPrefix('news_');
        //  $form->setFieldNameSuffix('news');

        // $post = $this->galleryFactory->create();
        // $collection = $post->getCollection()->getData();
        
       
        $form->setFieldNameSuffix('news');

        $fieldset = $form->addFieldset('edit_fieldset', [
            'legend' => __('General Information'),
        ]);


        
        if ($model->getId()) {
            $fieldset->addField(
                'id',
                'hidden',
                ['name' => 'id',
                'value'    => $model->getId(),
                ]
            );
            
            

           
        }
        $fieldset->addField(
            'title',
            'text',
            [
                'name'        => 'title',
                'label'    => __('Title'),
                'value'    => $model->getName(),
                // 'required'     => true
            ]
        );
        $fieldset->addField(
            'status',
            'select',
            [
                'name'      => 'status',
                'label'     => __('Status'),
                'value'  => $model->getStatus(),
            'values' => ['0' => __('Disabled'), '1' => __('Enabled')],
            ]
        );
        $fieldset->addField(
            'summary',
            'textarea',
            [
                'name'      => 'summary',
                'label'     => __('Summary'),
                'value'    => $model->getSummary(),
                // 'required'  => true,
                'style'     => 'height: 15em; width: 30em;'
            ]
        );
        $wysiwygConfig = $this->_wysiwygConfig->getConfig();
        $fieldset->addField(
            'description',
            'editor',
            [
                'name'        => 'description',
                'label'    => __('Description'),
                'value'    => $model->getDes(),
                // 'required'     => true,
                'config'    => $wysiwygConfig
            ]
        );
/***--------------------------------------------------- */
        $img =  $model->getImage();
         if(isset($img)){
            $fieldset->addField('nameDesktop', 'hidden', 
            [
              
                'name' => 'nameDesktop',
                'nameDesktop'     => 'name',
                'value'    => $img,
            ]); 
        }

        $fieldset->addField(
            'obj_user',
            'select',
            [
                'name'      => 'obj_user',
                'label'     => __('Object User'),
                'value'    => $model->getObj(),
                'values' => ['0' => __('Seller and Customer'), '1' => __('Seller') ,'2' => __('Customer')],
            ]
        );

        $fieldset->addField('image_noti','image',[
            'name' => 'image_noti',
            'label' => __('Image Notification'),
           'title' => __('upload'),
           'required'     => true,
            'style' => 'visibility:hidden',
            'before_element_html' => '<button type="button" onclick="document.getElementById(\'image_noti\').click(); return false;">Upload</button>',

            'files' => ['*.gif', '*.jpg', '*.jpeg', '*.png'],
           
           
        ]);
        
/**------------------------------------------------------- */
       
      //  $form->setValues($data);
      

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('News Info');
    }
 
    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('News Info');
    }
 
    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }
 
    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }
}