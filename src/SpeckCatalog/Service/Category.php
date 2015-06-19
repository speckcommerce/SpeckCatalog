<?php

namespace SpeckCatalog\Service;

class Category extends AbstractService
{
    protected $entityMapper = 'speckcatalog_category_mapper';
    protected $productService;
    protected $productUomService;
    protected $productImageService;
    protected $optionService;
    protected $siteId;

    public function findById($categoryId)
    {
        return $this->find(array('category_id' => $categoryId));
    }

    public function getCategoriesForNavigation()
    {
        $categories = $this->getChildCategories(null, $this->getSiteId());
        foreach ($categories as $cat) {
            $cats = $this->getChildCategories($cat->getCategoryId(), $this->getSiteId());
            $cat->setCategories($cats);
        }
        return $categories;
    }

    public function getByProductId($productId)
    {
        return $this->getEntityMapper()->getByProductId($productId, $this->getSiteId());
    }

    public function getCrumbs($category, $crumbs = array())
    {
        array_unshift($crumbs, $category);
        $parent = $this->getParentCategory($category->getCategoryId());
        if ($parent) {
            return $this->getCrumbs($parent, $crumbs);
        }
        return $crumbs;
    }

    public function getParentCategory($categoryId)
    {
        return $this->getEntityMapper()->getParentCategory($categoryId);
    }

    public function getCategoriesForTreePreview($siteId, $parentCategoryId = null)
    {
        $categories = $this->getEntityMapper()->getChildCategories($parentCategoryId, $siteId);
        foreach ($categories as $category) {
            $category->setCategories($this->getCategoriesForTreePreview($siteId, $category->getCategoryId()));
            //$products = $this->getProductService()->getByCategoryId($category->getCategoryId());
            //$category->setProducts($products);
        }

        return $categories;
    }

    public function getCategoryforView($categoryId, $paginationOptions = null)
    {
        $category = $this->findById($categoryId);
        if (!$category) {
            return;
        }

        $categories = $this->getChildCategories($categoryId, $this->getSiteId());
        $products = $this->getProductService()->usePaginator($paginationOptions)->getByCategoryId($categoryId);
        if (count($products) > 0) {
            foreach ($products as $product) {
                $this->getProductService()->populate($product, array('images', 'uoms', 'options', 'builders'), true);
            }
            $category->setProducts($products);
        }
        $category->setCategories($categories);

        return $category;
    }

    public function getChildCategories($categoryId, $siteId)
    {
        return $this->getEntityMapper()->getChildCategories($categoryId, $siteId);
    }

    public function addProduct($categoryOrId, $productOrId)
    {
        $categoryId = ( is_numeric($categoryOrId) ? $categoryOrId : $categoryOrId->getCategoryId() );
        $productId = ( is_numeric($productOrId) ? $productOrId  : $productOrId->getProductId() );

        return $this->getEntityMapper()->addProduct($categoryId, $productId);
    }

    public function addCategory($parentCategoryOrIdOrNull, $categoryOrId)
    {
        if (null === $categoryOrId) {
            throw new \RuntimeException('categoryOrId cannot be null');
        }
        $categoryId = ( is_numeric($categoryOrId) ? $categoryOrId : $categoryOrId->getCategoryId() );

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
            $this->productService = $this->getServiceLocator()->get('speckcatalog_product_service');
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
            $this->productUomService = $this->getServiceLocator()->get('speckcatalog_product_uom_service');
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
            $this->optionService = $this->getServiceLocator()->get('speckcatalog_option_service');
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
            $this->productImageService = $this->getServiceLocator()->get('speckcatalog_product_image_service');
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

    /**
     * @return siteId
     */
    public function getSiteId()
    {
        return $this->siteId;
    }

    /**
     * @param $siteId
     * @return self
     */
    public function setSiteId($siteId)
    {
        $this->siteId = $siteId;
        return $this;
    }
}
