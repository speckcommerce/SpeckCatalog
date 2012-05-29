<?php
namespace Catalog\Service;
use Exception,
    RuntimeException,
    Zend\ServiceManager\ServiceManagerAwareInterface,
    Zend\ServiceManager\ServiceManager;     

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
class CatalogService implements ServiceManagerAwareInterface 
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
    protected $serviceManager;
    
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }

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
        if(null === $this->productService){
            $this->productService = $this->getServiceManager()->get('catalog_product_service');
        }
        return $this->productService;     
    }
 
    public function getOptionService()
    {
        if(null === $this->optionService){
            $this->optionService = $this->getServiceManager()->get('catalog_option_service');
        }
        return $this->optionService;     
    }

    public function getChoiceService()
    {
        if(null === $this->choiceService){
            $this->choiceService = $this->getServiceManager()->get('catalog_choice_service');
        }
        return $this->choiceService;  
    }

    public function getProductUomService()
    {
        if(null === $this->productUomService){
            $this->productUomService = $this->getServiceManager()->get('catalog_product_uom_service');
        }
        return $this->productUomService;  
    }

    public function getAvailabilityService()
    {
        if(null === $this->availabilityService){
            $this->availabilityService = $this->getServiceManager()->get('catalog_availability_service');
        }
        return $this->availabilityService;  
    }

    public function getCategoryService()
    {
        if(null === $this->categoryService){
            $this->categoryService = $this->getServiceManager()->get('catalog_category_service');
        }
        return $this->categoryService;   
    }

    public function getSpecService()
    {
        if(null === $this->specService){
            $this->specService = $this->getServiceManager()->get('catalog_spec_service');
        }
        return $this->specService;  
    }

    public function getImageService()
    {
        if(null === $this->imageService){
            $this->imageService = $this->getServiceManager()->get('catalog_image_service');
        }
        return $this->imageService; 
    }
    
    public function getDocumentService()
    {
        if(null === $this->documentService){
            $this->documentService = $this->getServiceManager()->get('catalog_document_service');
        }
        return $this->documentService; 
    }
    
    public function getServiceManager()
    {
        return $this->serviceManager;
    }
}
