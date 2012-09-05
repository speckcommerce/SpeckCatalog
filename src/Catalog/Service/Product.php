<?php

namespace Catalog\Service;

class Product extends AbstractService
{
    protected $entityMapper = 'catalog_product_mapper';
    protected $optionService;
    protected $productUomService;
    protected $imageService;

    public function find($productId, $populate=false, $recursive=false)
    {
        $product = $this->getEntityMapper()->find($productId);
        if($populate) {
            $this->populate($product, $recursive);
        }
        return $product;
    }

    public function getFullProduct($productId)
    {
        $product = $this->find($productId);
        $this->populate($product, true);
        return $product;
    }

    public function populate($product, $recursive=false)
    {
        $productId = $product->getProductId();
        $product->setOptions($this->getOptionService()->getByProductId($productId, true, $recursive));
        $product->setImages($this->getImageService()->getImages('product', $productId));
        $product->setUoms($this->getProductUomService()->getByProductId($productId, true, $recursive));
    }

    public function addOption($productOrId, $optionOrId)
    {
        $productId = ( is_int($productOrId) ? $productOrId : $productOrId->getProductId() );
        $optionId  = ( is_int($optionOrId)
            ? $optionOrId
            : $this->getOptionMapper()->persist($optionOrId)->getOptionId()
        );
        $this->getEntityMapper()->addOption($productId, $optionId);
    }

    public function removeOption($productOrId, $optionOrId)
    {
        $productId = ( is_int($productOrId) ? $productOrId : $productOrId->getProductId() );
        $optionId  = ( is_int($optionOrId)  ? $optionOrId  : $optionOrId->getOptionId() );
        $this->getEntityMapper()->removeOption($productId, $optionId);
    }

    public function addImage($productOrId, $image)
    {
        $productId = ( is_int($productOrId) ? $productOrId : $productOrId->getProductId() );
        return $this->getImageService()->addLinker('product', $productId, $image);
    }

    public function populateForPricing($product)
    {
        //recursive options (only whats needed for pricing)
        //productUoms, Availabilities
        //
    }

    public function getByCategoryId($categoryId)
    {
        return $this->getEntityMapper()->getByCategoryId($categoryId);
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
}
