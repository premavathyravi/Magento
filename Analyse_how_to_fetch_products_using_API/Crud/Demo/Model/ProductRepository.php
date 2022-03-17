<?php
namespace Crud\Demo\Model;

use Crud\Demo\Api\ConfigurableProductRepositoryInterface;
use Crud\Demo\Api\ProductRepositoryInterface;
use Crud\Demo\Api\Data\ProductInterfaceFactory;
use Crud\Demo\Helper\ProductHelper;
use Magento\Framework\Exception\NoSuchEntityException;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * @var ProductInterfaceFactory
     */
    private $productInterfaceFactory;

    /**
     * @var ProductHelper
     */
    private $productHelper;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */

    private $productRepository;

    /**
     * ProductRepository constructor
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param ProdcutInterfaceFactory $productInterfaceFactory
     * @param ProductHelper $productHelper
     */

    public function __construct(
         \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
         ProductInterfaceFactory $productInterfaceFactory,
         ProductHelper $productHelper
    )
    {
        $this->productInterfaceFactory = $productInterfaceFactory;
        $this->productHelper = $productHelper;
        $this->productRepository = $productRepository;
    }

    /**
     * get product by its ID
     * @param int $id
     * @return \Crud\Demo\Api\Data\ProductInterface
     * @throws NoSuchEntityException
     * 
     */
    public function getProductById($id)
    {
        /** @var \Crud\Demo\Api\Data\ProductInterface $productInterface    */
        $productInterface = $this->productInterfaceFactory->create();
        try {
            /** @var \Magento\Catalog\Api\Data\ProductInterface $product */
            $product = $this->productRepository->getById($id);
            $productInterface->setId($product->getId());
            $productInterface->setSku($product->getSku());
            $productInterface->setName($product->getName());
            $productInterface->setDescription($product->getDescription() ? $product->getDescription():"");
            $productInterface->setPrice($this->productHelper->formatPrice($product->getPrice()));
            $productInterface->setImages($this->productHelper->getProductImagesArray($product));
            return $productInterface;
        }catch(NosuchEntityException $e)
        {
            throw NoSuchEntityException::singleField("id",$id);
        }

    }

}

?>