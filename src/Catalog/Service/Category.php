<?php

namespace Catalog\Service;

class Category extends AbstractService
{
    protected $entityMapper = 'catalog_category_mapper';
    protected $productService;
    protected $productUomService;
    protected $productImageService;
    protected $optionService;

    public function findById($categoryId)
    {
        return $this->find(array('category_id' => $categoryId));
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

    public function getCrumbs($category)
    {
        return $this->getEntityMapper()->getCrumbs($category);
    }

    public function getCategoryforView($categoryId, $paginationOptions=null)
    {
        $category = $this->findById($categoryId);
        if (!$category) return;

        $categories = $this->getChildCategories($categoryId);
        $products = $this->getProductService()->getByCategoryId($categoryId, $paginationOptions);
        foreach($products as $product){
            $product->setImages($this->getProductImageService()->getImages('product', $product->getProductId()));
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

    public function addProduct($categoryOrId, $productOrId)
    {
        $categoryId = ( is_int($categoryOrId) ? $categoryOrId : $categoryOrId->getCategoryId() );
        $productId = ( is_int($productOrId) ? $productOrId  : $productOrId->getProductId() );

        return $this->getEntityMapper()->addProduct($categoryId, $productId);
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

    public function setImage($categoryOrId, $imageOrId)
    {
        $categoryId = ( is_int($categoryOrId) ? $categoryOrId : $categoryOrId->getCategoryId() );
        $imageId    = ( is_int($imageOrId)    ? $imageOrId    : $imageOrId->getMediaId() );

        return $this->getImageService()->addLinker('category', $categoryId, $imageId);
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

    /**
     * @return productImageService
     */
    public function getProductImageService()
    {
        if (null === $this->productImageService) {
            $this->productImageService = $this->getServiceLocator()->get('catalog_product_image_service');
        }
        return $this->productImageService;
    }

    /**
     * @param $productImageService
     * @return self
     */
    public function setProductImageService($productImageService)
    {
        $this->productImageService = $productImageService;
        return $this;
    }
}
