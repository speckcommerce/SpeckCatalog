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
            $model = $this->getModelService($class)->getById((int)$id);
            if(null === $model){
                throw new Exception(get_class($this->getModelService($class)) . '::getById(' . $id . ') - returned null');
            }
            return $model;
        }
    }

    private function getModelService($class)
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

    public function newModel($class, $constructor = null)
    {
        return $this->getModelService($class)->newModel($constructor);
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
            return $this->linkNewModel($newClassName, $parentClassName, $parentId, $childClassName, $childId);
        }
        return $this->linkExistingModel($className, $id, $parentClassName, $parentId);
    }
    
    private function linkNewModel($newClassName, $parentClassName, $parentId, $childClassName = null, $childId = null)
    {
        $newParentChild =  'new' . ucfirst($parentClassName) . ucfirst($newClassName); 
        $model = $this->getModelService($newClassName)->$newParentChild($parentId);
        $linkerId = $this->linkParent($newClassName, $model->getId(), $parentClassName, $parentId);
        if($childClassName && $childId){
            $this->linkParent($childClassName, $childId, $newClassName, $model->getId());
        }
        $model = $this->getModelService($newClassName)->getById($model->getId());
        if (is_callable(array($model,'setLinkerId'))){
            $model->setSortWeight(0);
            $model->setLinkerId($linkerId);
        }
        return $model;
    }

    private function linkExistingModel($className, $id, $parentClassName, $parentId)
    {
        $this->linkParent($className, $id, $parentClassName, $parentId);
        return $this->getModelService($className)->getById($id);
    }
   
    private function linkParent($className, $id, $parentClassName, $parentId)
    {
        $linkParentClass = 'linkParent' . ucfirst($parentClassName);
        if(method_exists($this->getModelService($className), $linkParentClass)){
            return $this->getModelService($className)->$linkParentClass($parentId, $id);
        }

        //doesnt use a linker! - try and set the child id in the parent record.
        $setChildClassId = 'setChild' . ucfirst($className) . 'Id';
        if(method_exists($this->getModelService($parentClassName), $setChildClassId)){
            $this->getModelService($parentClassName)->$setChildClassId($parentId, $id);
        }
        
        return;
    }

    public function removeLinker($className, $linkerId)
    {
        var_dump($this->getModelService($className)->removeLinker($linkerId));
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
