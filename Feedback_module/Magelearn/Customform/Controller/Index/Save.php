<?php

namespace Magelearn\Customform\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magelearn\Customform\Model\CustomformFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Image\AdapterFactory;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Store\Model\StoreManagerInterface; 
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Save extends \Magento\Framework\App\Action\Action
{
	/**
     * @var Customform
     */
    protected $_customform;
    protected $uploaderFactory;
    protected $adapterFactory;
    protected $filesystem;
    protected $transportBuilder;
    protected $storeManager;
    protected $scopeConfig;

    public function __construct(
		Context $context,
        CustomformFactory $customform,
        UploaderFactory $uploaderFactory,
        AdapterFactory $adapterFactory,
        Filesystem $filesystem,
        TransportBuilder $transportBuilder,
        StoreManagerInterface $storeManager,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->_customform = $customform;
        $this->uploaderFactory = $uploaderFactory;
        $this->adapterFactory = $adapterFactory;
        $this->filesystem = $filesystem;
        $this->_storeManager = $storeManager;
        $this->_transportBuilder = $transportBuilder;
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context);
    }
	public function execute()
    {
        $adminemail = $this->scopeConfig->getValue('trans_email/ident_support/email',ScopeInterface::SCOPE_STORE);
        $adminname  = $this->scopeConfig->getValue('trans_email/ident_support/name',ScopeInterface::SCOPE_STORE);
 
    	if (!$this->getRequest()->isPost()) {
            return $this->resultRedirectFactory->create()->setPath('*/*/');
        }
        //$data = $this->getRequest()->getParams();
        $data = $this->validatedParams();
        $customeremail = $data['email'];
        $customername = $data['first_name'].' '.$data['last_name'];
    
    	$customform = $this->_customform->create();
        $resultRedirect = $this->resultRedirectFactory->create();
        $customform->setData($data);
        if($customform->save())
        {
            $store = $this->_storeManager->getStore()->getId();
            $maildata = [
                'name'  => $data['first_name'].' '.$data['last_name'],
                'email'  => $data['email'],
                'comment' => $data['message']
            ];

            $postObject = new \Magento\Framework\DataObject();
            $postObject->setData($maildata);

            $transport = $this->_transportBuilder->setTemplateIdentifier('customer_email_template')
                ->setTemplateOptions(['area' => 'frontend', 'store' => $store])
                ->setTemplateVars(['data' => $postObject])
                ->setFrom('general')
                ->addTo($customeremail,$customername)
                ->addBcc($adminemail,$adminname)
                ->getTransport();
            $transport->sendMessage();

            $this->messageManager->addSuccessMessage(__('You have successfully submitted the feedback'));
            return $resultRedirect->setPath('/');
        }
        else{
            $this->messageManager->addErrorMessage(__('Data was not saved.'));
        }
      
        $resultRedirect->setPath('customform');
        return $resultRedirect;
    }
/**
     * @return array
     * @throws \Exception
     */
    private function validatedParams()
    {
        $request = $this->getRequest();
        if (trim($request->getParam('first_name')) === '') {
            throw new LocalizedException(__('Enter the First Name and try again.'));
        }
		if (trim($request->getParam('last_name')) === '') {
            throw new LocalizedException(__('Enter the Last Name and try again.'));
        }
		if (false === \strpos($request->getParam('email'), '@')) {
            throw new LocalizedException(__('The email address is invalid. Verify the email address and try again.'));
        }
		if (trim($request->getParam('message')) === '') {
            throw new LocalizedException(__('Enter your message and try again.'));
        }
        return $request->getParams();
    }
}
