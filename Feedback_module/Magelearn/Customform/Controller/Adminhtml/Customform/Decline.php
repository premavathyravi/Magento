<?php
declare(strict_types=1);

namespace Magelearn\Customform\Controller\Adminhtml\Customform;


class Decline extends \Magelearn\Customform\Controller\Adminhtml\Customform
{
    protected $transportBuilder;
    protected $storeManager;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
    ) {
        $this->_transportBuilder = $transportBuilder;
        $this->_storeManager = $storeManager;
        parent::__construct($context, $coreRegistry);
    }
    /**
     * Decline action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
      /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect  */

        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be declined
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                // init model and decline
                $model = $this->_objectManager->create(\Magelearn\Customform\Model\Customform::class);
                $model->load($id);
                $customeremail = $model->getEmail();
                $customername = $model->getFirstName().' '.$model->getLastName();
                $customermessage = $model->getMessage();
                $model->setStatus(false);
                $model->save();

                //send email via smtp
                $maildata = [
                    'name'  => $customername,
                    'comment' => $customermessage
                ];
    
                $postObject = new \Magento\Framework\DataObject();
                $postObject->setData($maildata);

                $store = $this->_storeManager->getStore()->getId();
                $transport = $this->_transportBuilder->setTemplateIdentifier('decline_email_template')
                    ->setTemplateOptions(['area' => 'adminhtml', 'store' => $store])
                    ->setTemplateVars(['data' => $postObject])
                    ->setFrom('general')
                    ->addTo($customeremail, $customername)
                    ->getTransport();
               $transport->sendMessage();

                // display success message
                $this->messageManager->addSuccessMessage(__('You have Declined the Feedback.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Feedback to decline.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}

