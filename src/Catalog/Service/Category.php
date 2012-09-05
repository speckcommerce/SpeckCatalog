<?php

namespace Catalog\Service;

class Category extends AbstractService
{
    protected $entityMapper = 'catalog_category_mapper';
    protected $productService;
    protected $productUomService;
    protected $imageService;
    protected $optionService;

    public function find($categoryId)
    {
        return $this->getEntityMapper()->find($categoryId);
    }

    public function getCategoriesForNavigation()
    {
        $categories = $this->getChildCategories(null);
        foreach ($categories as $cat) {
            $cats = $this->getChildCategories($cat->getCategoryId());
            $cat->setCategories($cats);
        }
        return $categories;
    }

    public function getCategoryforView($categoryId)
    {
        $category = $this->find($categoryId);
        if (!$category) return;

        $categories = $this->getChildCategories($categoryId);
        //foreach($categories as $child){
        //    $image = $this->getImageService()->getImageForCategory($child->getCategoryId());
        //    $child->setImage($image);
        //}
        $products = $this->getProductService()->getByCategoryId($categoryId);
        foreach($products as $product){
            $product->setImages($this->getImageService()->getImages('product', $product->getProductId()));
            $product->setUoms($this->getProductUomService()->getByProductId($product->getProductId()));
            $product->setOptions($this->getOptionService()->getByProductId($product->getProductId(), true, true));
        }
        $category->setCategories($categories);
        $category->setProducts($products);
        return $category;
    }

    public function getChildCategories($categoryId)
    {
        return $this->getEntityMapper()->getChildCategories($categoryId);
    }

    public function addCategory($parentCategoryOrIdOrNull = null, $categoryOrId)
    {
        $categoryId = ( is_int($categoryOrId) ? $categoryOrId : $categoryOrId->getCategoryId() );

        $parentCategoryId = (
            is_int($parentCategoryOrIdOrNull)
            ? $parentCategoryOrIdOrNull
            : (is_null($parentCategoryOrIdOrNull)
                ? null
                : $parentCategoryOrIdOrNull->getCategoryId()
            )
        );

        return $this->getEntityMapper()->addCategory($parentCategoryId, $categoryId);
    }

    /**
     * @return productService
     */
    public function getProductService()
    {
        if (null === $this->productService) {
            $this->productService = $this->getServiceLocator()->get('catalog_product_service');
        }
        return $this->productService;
    }

    /**
     * @param $productService
     * @return self
     */
    public function setProductService($productService)
    {
        $this->productService = $productService;
        return $this;
    }

    /**
     * @return productUomService
     */
    public function getProductUomService()
    {
        if (null === $this->productUomService) {
            $this->productUomService = $this->getServiceLocator()->get('catalog_product_uom_service');
        }
        return $this->productUomService;
    }

    /**
     * @param $productUomService
     * @return self
     */
    public function setProductUomService($productUomService)
    {
        $this->productUomService = $productUomService;
        return $this;
    }

    /**
     * @return imageService
     */
    public function getImageService()
    {
        if (null === $this->imageService) {
            $this->imageService = $this->getServiceLocator()->get('catalog_image_service');
        }
        return $this->imageService;
    }

    /**
     * @param $imageService
     * @return self
     */
    public function setImageService($imageService)
    {
        $this->imageService = $imageService;
        return $this;
    }

    /**
     * @return optionService
     */
    public function getOptionService()
    {
        if (null === $this->optionService) {
            $this->optionService = $this->getServiceLocator()->get('catalog_option_service');
        }
        return $this->optionService;
    }

    /**
     * @param $optionService
     * @return self
     */
    public function setOptionService($optionService)
    {
        $this->optionService = $optionService;
        return $this;
    }
}
