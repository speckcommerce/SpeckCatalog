<?php

namespace Catalog\Service;

class CategoryService extends ServiceAbstract
{
    protected $productService;

    public function getCategoriesForNavigation()
    {
        return $this->getChildCategories(0, true);
    }

    public function getCategoriesForManagement($parentId = 0)
    {
        $categories = $this->getChildCategories($parentId);
        foreach($categories as $category){
            $products = $this->getProductService()->getProductsByCategoryId($category->getCategoryId());
            $category->setProducts($products);
            $childCategories = $this->getCategoriesForManagement($category->getCategoryId());
            $category->setCategories($childCategories);
        }
        return $categories;
    }

    public function getCategoryforView($categoryId)
    {
        $category = $this->getById($categoryId);
        if (!$category) {
            return;
        }

        $categories = $this->getChildCategories($categoryId);
        $imageService = $this->getProductService()->getImageService();
        foreach($categories as $child){
            $image = $imageService->getImageForCategory($child->getCategoryId());
            $child->setImage($image);
        }
        $products = $this->getProductService()->getProductsByCategoryId($categoryId);
        $productUomService = $this->getProductService()->getProductUomService();
        $optionService = $this->getProductService()->getOptionService();
        foreach($products as $product){
            $product->setImages($imageService->getImagesByProductId($product->getProductId()));
            $product->setUoms($productUomService->getByParentProductId($product->getProductId()));
            $product->setOptions($optionService->getOptionsByProductId($product->getProductId()));

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
