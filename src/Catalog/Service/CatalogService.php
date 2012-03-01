<?php
namespace Catalog\Service;
use Exception,
    RuntimeException;

class CatalogService
{
    protected $productService;
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
        $modelService = $this->$getModelService();
        return $modelService->getAll();
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
}
