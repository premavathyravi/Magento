<?php

namespace Magelearn\Customform\Block;

use Magento\Customer\Model\Session;

/**
 * Customform content block
 */
class Customform extends \Magento\Framework\View\Element\Template
{
     /**
     * @var \Magento\Framework\App\Http\Context
     */
    protected $httpContext;
    protected $customerSession;
    /**
     * Index constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     *  @param \Magento\Framework\App\Http\Context   
     *  @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\App\Http\Context $httpContext,
        array $data = []
    )
    {
        $this->httpContext = $httpContext;
       
        parent::__construct($context, $data);
    }

    public function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set(__('Customer Feedback')); 
        return parent::_prepareLayout();
    }

    public function getCustomerIsLoggedIn()
    {
    	return (bool)$this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
    }

    public function getCustomerId()
    {
    	return $this->httpContext->getValue('customer_id');
    }

    public function getCustomerName()
    {
    	return $this->httpContext->getValue('customer_name');
    }

    public function getCustomerEmail()
    {
    	return $this->httpContext->getValue('customer_email');
    }

    
   
}   
