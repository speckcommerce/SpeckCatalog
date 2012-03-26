<?php

namespace Catalog\Service;

class CategoryService extends ServiceAbstract
{
    protected $productService;

    public function populateModel($category)
    {
        $categories = $this->getModelMapper()->getChildCategories($category->getCategoryId());
        if($categories){
            $category->setCategories($categories);
        }
        $products = $this->getProductService()->getProductsByCategoryId($category->getCategoryId());
        if($products){
            $category->setProducts($products);
        }
        return $category;   
    }   

    public function getProductService()
    {
        return $this->productService;
    }

    public function setProductService($productService)
    {
        $this->productService = $productService;
        return $this;
    }
}
