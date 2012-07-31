<?php

namespace Catalog\Service;

class CategoryService extends ServiceAbstract
{
    protected $productService;

    public function getCategoriesForNavigation()
    {
        return $this->getChildCategories(0, true);
    }

    public function getCategoryforView($categoryId)
    {
        $category = $this->getById($categoryId);

        $categories = $this->getChildCategories($categoryId);
        $products = $this->getProductService()->getProductsByCategoryId($categoryId);
        $imageService = $this->getProductservice()->getImageService();
        foreach($products as $product){
            $product->setImages($imageService->getImagesByProductId($product->getProductId()));
        }
        $category->setCategories($categories);
        $category->setProducts($products);
        return $category;
    }

    public function _populateModel($category)
    {
        $products = $this->getProductService()->getProductsByCategoryId($category->getCategoryId());
        if($products){
            foreach($products as $i => $product){
                $products[$i] = $this->getProductService()->populateModel($product);
            }
            $category->setProducts($products);
        }
        return $category;
    }

    private function getChildCategories($categoryId, $recursive=false)
    {
        $categories = $this->getModelMapper()->getChildCategories($categoryId);
        foreach ($categories as $category){
            if($recursive){
                $childCategories = $this->getChildCategories($category->getCategoryId(),  true);
                $category->setCategories($childCategories);
            }
        }
        return $categories;
    }

    public function getAll()
    {
        $categories = $this->getModelMapper()->getAll();
        foreach ($categories as $i => $category){
            $categories[$i] = $this->populateModel($category);
        }
        return $categories;
    }

    public function newCategoryCategory($parentCategoryId)
    {
        $category = $this->newModel();
        $this->linkParentCategory($parentCategoryId, $category->getCategoryId());

        return $category;
    }

    public function linkParentCategory($parentId, $childId)
    {
        return $this->getModelMapper()->linkParentCategory($parentId, $childId);
    }

    public function getProductService()
    {
        if(null === $this->productService){
            $this->productService = $this->getServiceManager()->get('catalog_product_service');
        }
        return $this->productService;
    }

    public function setProductService($productService)
    {
        $this->productService = $productService;
        return $this;
    }

    public function getModelMapper()
    {
        if(null === $this->modelMapper){
            $this->modelMapper = $this->getServiceManager()->get('catalog_category_mapper');
        }
        return $this->modelMapper;
    }



}
