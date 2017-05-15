<?php


namespace Experius\AlternativeCatalog\Model;

class Product implements \Magento\Catalog\Api\ProductRepositoryInterface
{


    protected $productRepository;

    protected $productFactory;

    public function __construct(
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Catalog\Model\ProductFactory $productFactory
    )
    {
        $this->productRepository = $productRepository;
        $this->productFactory = $productFactory;
    }

    public function save(\Magento\Catalog\Api\Data\ProductInterface $product, $saveOptions = false)
    {
        return $this->productRepository->save($product,$saveOptions);
    }

    public function get($sku, $editMode = false, $storeId = null, $forceReload = false)
    {
        if($sku=='24-MB01' || $sku=='my-non-existing-product'){
            return $this->getAlternativeProduct();
        } else {
            return $this->productRepository->get($sku, $editMode, $storeId, $forceReload);
        }
    }

    public function getById($productId, $editMode = false, $storeId = null, $forceReload = false)
    {
        if($productId=='1' || $productId=='9999'){
            return $this->getAlternativeProduct();
        } else {
            return $this->productRepository->getById($productId, $editMode, $storeId, $forceReload);
        }

    }

    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        return $this->getList($searchCriteria);
    }

    public function delete(\Magento\Catalog\Api\Data\ProductInterface $product)
    {
        return $this->productRepository->delete($product);
    }

    public function deleteById($sku)
    {
        return $this->productRepository->deleteById($sku);
    }

    public function getAlternativeProduct(){

        // Callback to remote database, or alternative module;
        $data = [
            'id'=>'9999',
            'sku'=>'my-non-existing-product',
            'name'=>'My non existing product',
            'price'=>'100'
        ];

        return $this->createMagentoProductObject($data);

    }

    public function createMagentoProductObject($data){

        $product = $this->productFactory->create();
        $product->setEntityId($data['id']);
        $product->setId($data['id']);
        $product->setSku($data['sku']);
        $product->setPrice($data['price']);
        $product->setFinalPrice($data['price']);
        $product->setName('My non existing product');
        $product->setWebsiteIds([1,2,3,4,5,6]);
        $product->setTypeId('simple');

        return $product;
    }

}