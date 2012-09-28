<?php

namespace Catalog\Service;

class Product extends AbstractService
{
    protected $entityMapper = 'catalog_product_mapper';
    protected $optionService;
    protected $productUomService;
    protected $imageService;
    protected $documentService;
    protected $specService;
    protected $companyService;

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
        $product->setDocuments($this->getDocumentService()->getDocuments('product', $productId));
        $product->setUoms($this->getProductUomService()->getByProductId($productId, true, $recursive));
        $product->setSpecs($this->getSpecService()->getByProductId($productId));
        $product->setManufacturer($this->getCompanyService()->find($product->getManufacturerId()));
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
    public function addDocument($productOrId, $document)
    {
        $productId = ( is_int($productOrId) ? $productOrId : $productOrId->getProductId() );
        return $this->getDocumentService()->addLinker('product', $productId, $document);
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
            $this->imageService = $this->getServiceLocator()->get('catalog_product_image_service');
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
     * @return documentService
     */
    public function getDocumentService()
    {
        if (null === $this->documentService) {
            $this->documentService = $this->getServiceLocator()->get('catalog_document_service');
        }
        return $this->documentService;
    }

    /**
     * @param $documentService
     * @return self
     */
    public function setDocumentService($documentService)
    {
        $this->documentService = $documentService;
        return $this;
    }

    /**
     * @return specService
     */
    public function getSpecService()
    {
        if (null === $this->specService) {
            $this->specService = $this->getServiceLocator()->get('catalog_spec_service');
        }
        return $this->specService;
    }

    /**
     * @param $specService
     * @return self
     */
    public function setSpecService($specService)
    {
        $this->specService = $specService;
        return $this;
    }

    /**
     * @return companyService
     */
    public function getCompanyService()
    {
        if (null === $this->companyService) {
            $this->companyService = $this->getServiceLocator()->get('catalog_company_service');
        }
        return $this->companyService;
    }

    /**
     * @param $companyService
     * @return self
     */
    public function setCompanyService($companyService)
    {
        $this->companyService = $companyService;
        return $this;
    }
}
