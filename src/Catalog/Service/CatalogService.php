<?php
namespace Catalog\Service;
use Exception,
    RuntimeException;

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

    protected $mapper;

    public function getModel($class, $id=null)
    {
        if(0 === (int) $id){
            throw new RuntimeException('need an ID');
        } else {
            $getModelService = 'get' . ucfirst($class) . 'Service';
            $modelService = $this->$getModelService();
            $model = $modelService->getById((int)$id);
            if(null === $model){
                throw new Exception(get_class($modelService) . '::getById(' . $id . ') - returned null');
            }
            return $model;
        }
    }

    public function getAll($class)
    {
        $getModelService = 'get' . ucfirst($class) . 'Service';
        return $this->$getModelService()->getAll();
    }

    public function update($class, $id, $post)
    {
        $getModelService = 'get' . ucfirst($class) . 'Service';
        $return = $this->$getModelService()->updateModelFromArray($post);
        die($return->__toString());
    }

    public function searchClass($class, $value)
    {
        $getModelService = 'get' . ucfirst($class) . 'Service';
        return $this->$getModelService()->getModelsBySearchData($value);
    }


    public function newModel($class, $constructor = null, $relationData = null)
    {
        $getModelService = 'get' . ucfirst($class) . 'Service';
        $modelService = $this->$getModelService();
        $model = $modelService->newModel($constructor);

        if($relationData){
            if(isset($relationData['parent'])){
            }
            if(isset($relationData['child'])){
            }
        }
        return $model;
    }

    public function getCategories()
    {
        return $this->getCategoryService()->getChildCategories(0);
    }

    public function createCatalog()
    {
        return $this->getMapper()->createCatalog();
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
 
    public function getMapper()
    {
        return $this->mapper;
    }
 
    public function setMapper($mapper)
    {
        $this->mapper = $mapper;
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
