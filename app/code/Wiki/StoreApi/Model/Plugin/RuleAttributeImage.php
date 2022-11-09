<?php

namespace Wiki\StoreApi\Model\Plugin;

use Magento\SalesRule\Api\Data\RuleInterface;
use Magento\SalesRule\Model\Rule as RuleModel;
use Wiki\StoreApi\Helper\Data;
use Wiki\StoreApi\Model\Api\Data\Rule as ImageRule;

class RuleAttributeImage
{
    protected $storeManager;
    protected $ruleExtension;
    /**
     * 
     * @var ImageRule
     */
    protected $imageRule;

    /**
     * 
     * @var Wiki\StoreApi\Helper\Data
     */
    protected $helperData;

    public function __construct(
        \Magento\SalesRule\Api\Data\RuleExtensionFactory $ruleExtensionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        Data $helperData,
        ImageRule $imageRule
    ) {
        $this->ruleExtension = $ruleExtensionFactory;
        $this->storeManager = $storeManager;
        $this->helperData = $helperData;
        $this->imageRule = $imageRule;
    }

    public function afterGet(
        \Magento\SalesRule\Api\RuleRepositoryInterface $subject,
        \Magento\SalesRule\Api\Data\RuleInterface $rule
    ) {
        /** Get Current Extension Attributes from Rule */
        $ruleExtension = $rule->getExtensionAttributes();
        $extensionAttributes = $ruleExtension ? $ruleExtension : $this->ruleExtension->create();
        $image = $this->setRuleImage($rule);
        if ($image) {
            $extensionAttributes->setImage($image);
            $rule->setExtensionAttributes($extensionAttributes);
        }
        return $rule;
    }
    public function afterGetList($subject, $searchCriteria)
    {
        $products = [];
        foreach ($searchCriteria->getItems() as $entity) {
            /** Get Current Extension Attributes from Product */
            $ruleExtension = $entity->getExtensionAttributes();
            $extensionAttributes = $ruleExtension ? $ruleExtension : $this->ruleExtension->create();
            $image = $this->setRuleImage($entity);
            if ($image) {
                $extensionAttributes->setImage($image);
                $entity->setExtensionAttributes($extensionAttributes);
            }
            $rules[] = $entity;
        }
        $searchCriteria->setItems($rules);
        return $searchCriteria;
    }

    // Set Image Rule
    public function setRuleImage($rule)
    {
        $image = $this->helperData->getImageByRule($rule);
        if (!$image)
            return false;

        /** create Flash Sales */
        $data['image'] = $image;

        return [$data];
    }
}
