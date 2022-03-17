<?php
namespace Vendor\CustomModule\Controller\Adminhtml\Index;

class MassCancel extends \Magento\Backend\App\Action
{
    /**
     * __construct
     *
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * MassCancel Action
     *
     * @return \Magento\Framework\App\ResponseInterface
     */
    public function execute()
    {
        try {
            //write your code here
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }
        $this->_redirect("*/*/index");
    }
    
    /**
     * Check if user has permissions to access this controller
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed("Vendor_CustomModule::masscancel");
    }
}