<?php

namespace Catalog\Service;

class CategoryService extends ServiceAbstract
{
    protected $productService;

    public function populateModel($category)
    {
        $categories = $this->getModelMapper()->getChildCategories($category->getCategoryId());
        if($categories){
            foreach($categories as $i => $childCategory){
                $childCategories[$i] = $this->populateModel($childCategory);
                $category->setCategories($childCategories);
            }
        }
        $products = $this->getProductService()->getProductsByCategoryId($category->getCategoryId());
        if($products){
            $category->setProducts($products);
        }
        return $category;   
    }

    public function getAll()
    {
        $categories = $this->getModelMapper()->getAll();
        foreach ($categories as $i => $category){
            $categories[$i] = $this->populateModel($category);
        }
        return $categories;
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
