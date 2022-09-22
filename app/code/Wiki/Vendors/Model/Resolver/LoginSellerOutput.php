<?php
/**
 * @author Mohit Patel
 * @copyright Copyright (c) 2021
 * @package Mag_CustomForm
 */

namespace Wiki\Vendors\Model\Resolver;

use Wiki\Vendors\Api\SellerManagementInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class LoginSellerOutput implements ResolverInterface
{
    protected $sellerManagement;

    const EMAIL  = "email";

    const PASSWORD = "password";

   public function __construct(
    SellerManagementInterface $sellerManagement
    ) {
        $this->sellerManagement = $sellerManagement;
    }
    /**
     * @inheritdoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (empty($args['input']) || !is_array($args['input'])) {
            throw new GraphQlInputException(__('"input" value should be specified'));
        }
        if($this->sellerManagement->loginSeller($args['input'][self::EMAIL],$args['input'][self::PASSWORD])){
            return $this->setMessage(true,"Login Success");
        }
        return $this->setMessage(false,"Login Error");
    }
    public function setMessage($success,$message,array $value = null)
    {
        $value['success'] = $success;
        $value['message'] = $message;
        return $value;
    }
}