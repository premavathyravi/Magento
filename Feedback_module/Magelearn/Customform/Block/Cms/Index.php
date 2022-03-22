<?php

declare(strict_types=1);

namespace Magelearn\Customform\Block\Cms;


class Index extends \Magento\Framework\View\Element\Template
{
	protected $_productCollectionFactory;

    public function __construct(
		\Magento\Backend\Block\Template\Context $context,        
		\Magelearn\Customform\Model\ResourceModel\Customform\CollectionFactory $collectionFactory,        
		array $data = []
	)
	{    
		$this->_collectionFactory = $collectionFactory;    
		parent::__construct($context, $data);
	}

	public function getFeedbackCollections()
	{
		$collection = $this->_collectionFactory->create();
		$collection->addFieldToFilter('status',1);
		$collection->addFieldToSelect('message');
		return $collection;
	}
    
}

