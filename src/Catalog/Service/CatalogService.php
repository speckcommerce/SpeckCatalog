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

    public function updateSortOrder($class, $parent, $order)
    {
        $getModelService = 'get' . ucfirst($class) . 'Service';
        $modelService = $this->$getModelService();
        return $modelService->updateSortOrder($parent, $order);
    }

    public function linkModel($data)
    {
        $newClassName    = (isset($data['new_class_name'])    ? $data['new_class_name']    : null );
        $className       = (isset($data['class_name'])        ? $data['class_name']        : null );
        $id              = (isset($data['id'])                ? $data['id']                : null );
        $childClassName  = (isset($data['child_class_name'])  ? $data['child_class_name']  : null );
        $childId         = (isset($data['child_id'])          ? $data['child_id']          : null );
        $parentClassName = (isset($data['parent_class_name']) ? $data['parent_class_name'] : null );
        $parentId        = (isset($data['parent_id'])         ? $data['parent_id']         : null );

        if($newClassName){
            return $this->newModel($newClassName, $parentClassName, $parentId, $childClassName, $childId);
        }
        return $this->existingModel($className, $id, $parentClassName, $parentId);
    }
    
    private function newModel($newClassName, $parentClassName, $parentId, $childClassName = null, $childId = null)
    { 
        $modelService = $newClassName . 'Service';
        $newClass = 'new' . ucfirst($parentClassName) . ucfirst($newClassName);
        $model = $this->$modelService->$newClass($parentId);
        $linkerId = $this->linkParent($newClassName, $model->getId(), $parentClassName, $parentId);
        if($childClassName && $childId){
            $linkerId = $this->linkParent($childClassName, $childId, $newClassName, $model->getId());
        }
        $model = $this->$modelService->getById($model->getId());
        if (is_callable($model->setLinkerId())){
            $model->setSortWeight(0);
            $model->setLinkerId($linkerId);
        }
        return $model;
    }

    private function existingModel($className, $id, $parentClassName, $parentId)
    {
        $modelService = $className . 'Service';
        $this->linkParent($className, $id, $parentClassName, $parentId);
        return $this->$modelService->getById($id);
    }
   
    private function linkParent($className, $id, $parentClassName, $parentId)
    {
        $modelService = $className . 'Service';
        $linkParentClass = 'linkParent' . ucfirst($parentClassName);
        if(method_exists($this->$modelService, $linkParentClass)){
            return $this->$modelService->$linkParentClass($parentId, $id);
        } 
    }

    public function removeLinker($className, $linkerId)
    {
        $modelService = $className . 'Service';
        var_dump($this->$modelService->removeLinker($linkerId));
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
