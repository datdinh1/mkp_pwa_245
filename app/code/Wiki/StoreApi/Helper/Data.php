<?php
namespace Wiki\StoreApi\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper {
     //put your code here
    protected $scopeConfig;
    protected $_resouceModel;
    protected $_productFactory;

    /** @var \Magento\SalesRule\Api\RuleRepositoryInterface $rule **/

    protected $rule;
    /**
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\App\ResourceConnection $_resouceModel
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,

        \Magento\SalesRule\Model\Rule $rule,

        \Magento\Framework\App\ResourceConnection $_resouceModel
    ) {

        parent::__construct($context);
        $this->scopeConfig = $context->getScopeConfig();
        $this->_resourceModel = $_resouceModel;
        $this->rule = $rule;
    }
   
    public function getImageByRule($rule){
        $ruleId = '';
        $resource = $this->_resourceModel;
        if(is_numeric($rule)){
            $ruleId = $rule;
        } else {
            $ruleId = $rule->getId();
        }

         /** @var \Magento\SalesRule\Model\Rule $rule **/
         $ruleCol = $this->rule->load($ruleId);
         $imageFromBB = $ruleCol->getImage();
        return $imageFromBB;
    }

}
