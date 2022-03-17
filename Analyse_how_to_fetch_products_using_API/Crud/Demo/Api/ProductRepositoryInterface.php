<?php
namespace Crud\Demo\Api;

use Magento\Framework\Exception\NoSuchEntityException;

interface ProductRepositoryInterface
{
    /**
     * Get product by id
     * @param int $id
     * @return \Crud\Demo\Api\Data\ProductInterface
     * @throws NoSuchEntityException
     */
    public function getProductById($id);
}