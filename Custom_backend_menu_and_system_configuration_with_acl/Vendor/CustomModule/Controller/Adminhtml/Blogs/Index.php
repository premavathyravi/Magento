<?php

namespace Vendor\CustomModule\Controller\Adminhtml\Blogs;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;


class Index extends Action implements HttpGetActionInterface
{

	const MENU_ID = 'Vendor_CustomModule::index';

	protected $helperData;

	protected $resultPageFactory;

	public function __construct(
		\Magento\Backend\App\Action\Context $context,
		\Magento\Framework\View\Result\Pagefactory $resultPageFactory,
		\Vendor\CustomModule\Helper\Data $helperData

	)
	{
		
		parent::__construct($context);
		$this->helperData = $helperData;
		$this->resultPageFactory = $resultPageFactory;
	}

	public function execute()
	{
		// TODO: Implement execute() method.
		/*echo 'Enable  -> '.$this->helperData->getGeneralConfig('enable').'<br>';
		echo 'Display Text ->  '.$this->helperData->getGeneralConfig('display_text').'<br>';
		exit();*/
		$resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(static::MENU_ID);
        $resultPage->getConfig()->getTitle()->prepend(__('Hello World'));

        return $resultPage; 
	}

}
?>

