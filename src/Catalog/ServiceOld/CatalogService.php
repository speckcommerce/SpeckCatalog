<?php
namespace Catalog\Service;
use Exception;
use RuntimeException;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;

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
    protected $companyService;
    protected $serviceManager;

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }

    public function getService($class)
    {
        $getService = 'get' . ucfirst($class) . 'Service';
        return $this->$getService();
    }

    public function getAll($class)
    {
        return $this->getService($class)->getAll();
    }

    public function update($class, $id, $post)
    {
        return $this->getService($class)->update($post);
    }

    public function searchClass($class, $value)
    {
        return $this->getService($class)->getModelsBySearchData($value);
    }

    public function updateSortOrder($class, $parent, $order)
    {
        return $this->getService($class)->updateSortOrder($parent, $order);
    }

    public function getModel($class)
    {
        return $this->getService($class)->getModel();
    }

    public function getById($class, $id)
    {
        return $this->getService($class)->getById($id);
    }

    public function newModel($class, $constructor=null)
    {
        $model = $this->getService($class)->getModelMapper()->getModel($constructor);
        return $this->getService($class)->add($model);
    }

    public function removeLinker($class, $linkerId)
    {
        var_dump($this->getService($class)->removeLinker($linkerId));
        //todo: check for orphan records....
    }

    public function getCategories()
    {
        return $this->getCategoryService()->getChildCategories(0);
    }

    public function getCompanies()
    {
        return $this->getCompanyService()->getAll(0);
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

    public function getCompanyService()
    {
        if(null === $this->companyService){
            $this->companyService = $this->getServiceManager()->get('catalog_company_service');
        }
        return $this->companyService;
    }

    public function setCompanyService($companyService)
    {
        $this->companySerice = $companyService;
        return $this;
    }

    public function setProductService($productService)
    {
        $this->productService = $productService;
        return $this;
    }

    public function setProductUomService($productUomService)
    {
        $this->productUomService = $productUomService;
        return $this;
    }

    public function setAvailabilityService($availabilityService)
    {
        $this->availabilityService = $availabilityService;
        return $this;
    }

    public function setOptionService($optionService)
    {
        $this->optionService = $optionService;
        return $this;
    }

    public function setChoiceService($choiceService)
    {
        $this->choiceService = $choiceService;
        return $this;
    }

    public function setCategoryService($categoryService)
    {
        $this->categoryService = $categoryService;
        return $this;
    }

    public function setSpecService($specService)
    {
        $this->specService = $specService;
        return $this;
    }

    public function setImageService($imageService)
    {
        $this->imageService = $imageService;
        return $this;
    }

    public function setDocumentService($documentService)
    {
        $this->documentService = $documentService;
        return $this;
    }
}
