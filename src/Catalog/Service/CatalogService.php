<?php
namespace Catalog\Service;
use Exception,
    RuntimeException;

/**
 * CatalogService 
 * 
 * this is a generic wrapper service for all the other services
 * 
 * First parameter of all methods (lowercase, underscore_separated)
 * will be used to fetch the correct model service, one exception is the 'linkModel' 
 * method. 
 *
 */
class CatalogService
{
    protected $productService;
    protected $productUomService;
    protected $availabilityService;
    protected $optionService;
    protected $choiceService;
    protected $categoryService;
    protected $specService;
    protected $imageService;
    protected $documentService;

    public function getModelService($class)
    {
        $getModelService = 'get' . ucfirst($class) . 'Service';
        return $this->$getModelService();
    }

    public function getAll($class)
    {
        return $this->getModelService($class)->getAll();
    }

    public function update($class, $id, $post)
    {
        echo $this->getModelService($class)->updateModelFromArray($post); die();
    }

    public function searchClass($class, $value)
    {
        return $this->getModelService($class)->getModelsBySearchData($value);
    }

    public function updateSortOrder($class, $parent, $order)
    {
        return $this->getModelService($class)->updateSortOrder($parent, $order);
    }
   
    public function getModel($class, $id)
    {
        return $this->getModelService($class)->getById($id);
    }

    public function linkModel($data)
    {
        return $this->getModelLinkerService()->getAndLinkModel($data);
    }

    public function newModel($class, $constructor=null)
    {
        $model = $this->getModelService($class)->getModelMapper()->getModel($constructor);
        return $this->getModelService($class)->add($model);
    }

    public function removeLinker($class, $linkerId)
    {
        var_dump($this->getModelService($class)->removeLinker($linkerId));
        //todo: check for orphan records....
    }   

    public function getCategories()
    {
        return $this->getCategoryService()->getChildCategories(0);
    }

    public function truncateCatalog()
    {
        return $this->getMapper()->truncateCatalog();
    }

    public function dropCatalog()
    {
        return $this->getMapper()->dropCatalog();
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

    public function getOptionService()
    {
        return $this->optionService;
    }

    public function setOptionService($optionService)
    {
        $this->optionService = $optionService;
        return $this;
    }

    public function getChoiceService()
    {
        return $this->choiceService;
    }

    public function setChoiceService($choiceService)
    {
        $this->choiceService = $choiceService;
        return $this;
    }

    public function getProductUomService()
    {
        return $this->productUomService;
    }

    public function setProductUomService($productUomService)
    {
        $this->productUomService = $productUomService;
        return $this;
    }

    public function getAvailabilityService()
    {
        return $this->availabilityService;
    }

    public function setAvailabilityService($availabilityService)
    {
        $this->availabilityService = $availabilityService;
        return $this;
    }

    public function getCategoryService()
    {
        return $this->categoryService;
    }

    public function setCategoryService($categoryService)
    {
        $this->categoryService = $categoryService;
        return $this;
    }

    public function getSpecService()
    {
        return $this->specService;
    }

    public function setSpecService($specService)
    {
        $this->specService = $specService;
        return $this;
    }

    public function getImageService()
    {
        return $this->imageService;
    }

    public function setImageService($imageService)
    {
        $this->imageService = $imageService;
        return $this;
    }

    public function getDocumentService()
    {
        return $this->documentService;
    }

    public function setDocumentService($documentService)
    {
        $this->documentService = $documentService;
        return $this;
    }
}
