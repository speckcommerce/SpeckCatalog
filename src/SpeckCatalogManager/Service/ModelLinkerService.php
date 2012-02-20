<?php
namespace SpeckCatalogManager\Service;

class ModelLinkerService
{
    protected $productService;
    protected $optionService;
    protected $productUomService;
    protected $choiceService;
    protected $availabilityService;
    
    /**
     * link a new model to its parent
     * link an existing model to its parent
     * link an existing model to its parent, and link its child
     */

    public function linkModel($data)
    {
        if(isset($data['new_class_name']))   { $newClassName    = $data['new_class_name'];    }else{ $newClassName = null; }
        if(isset($data['class_name']))       { $className       = $data['class_name'];        }else{ $className = null; }
        if(isset($data['id']))               { $id              = (int) $data['id'];                }else{ $id = null; }
        if(isset($data['child_class_name'])) { $childClassName  = $data['child_class_name'];  }else{ $childClassName = null; }
        if(isset($data['child_id']))         { $childId         = (int) $data['child_id'];          }else{ $childId = null; }
        if(isset($data['parent_class_name'])){ $parentClassName = $data['parent_class_name']; }else{ $parentClassName = null; }
        if(isset($data['parent_id']))        { $parentId        = (int) $data['parent_id'];         }else{ $parentId = null; }

        if($newClassName){
            return $this->newModel($newClassName, $parentClassName, $parentId, $childClassName, $childId);
        }else{
            return $this->existingModel($className, $id, $parentClassName, $parentId);
        }
    }
    
    public function newModel($newClassName, $parentClassName, $parentId, $childClassName = null, $childId = null)
    { 
        $modelService = $newClassName . 'Service';
        $newClass = 'new' . ucfirst($parentClassName) . ucfirst($newClassName);
        $model = $this->$modelService->$newClass($parentId);
        $this->linkParent($newClassName, $model->getId(), $parentClassName, $parentId);
        if($childClassName && $childId){
            $this->linkParent($childClassName, $childId, $newClassName, $model->getId());
        }    
        return $this->$modelService->getById($model->getId());
    }

    public function existingModel($className, $id, $parentClassName, $parentId)
    {
        $modelService = $className . 'Service';
        $this->linkParent($className, $id, $parentClassName, $parentId);
        return $this->$modelService->getById($id);
    }
   
    public function linkParent($className, $id, $parentClassName, $parentId)
    {
        $modelService = $className . 'Service';
        $linkParentClass = 'linkParent' . ucfirst($parentClassName);
        if(method_exists($this->$modelService, $linkParentClass)){
            $this->$modelService->$linkParentClass($parentId, $id);
            echo '<script>console.log(\'' . $modelService . '::' . $linkParentClass . ' - called\')</script>';
        } else {
            echo '<script>console.log(\'' . $modelService . '::' . $linkParentClass . ' - NOT called\')</script>';
        }
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
 
    /**
     * Get productUomService.
     *
     * @return productUomService
     */
    public function getProductUomService()
    {
        return $this->productUomService;
    }
 
    /**
     * Set productUomService.
     *
     * @param $productUomService the value to be set
     */
    public function setProductUomService($productUomService)
    {
        $this->productUomService = $productUomService;
        return $this;
    }
 
    /**
     * Get choiceService.
     *
     * @return choiceService
     */
    public function getChoiceService()
    {
        return $this->choiceService;
    }
 
    /**
     * Set choiceService.
     *
     * @param $choiceService the value to be set
     */
    public function setChoiceService($choiceService)
    {
        $this->choiceService = $choiceService;
        return $this;
    }
 
    /**
     * Get productService.
     *
     * @return productService
     */
    public function getProductService()
    {
        return $this->productService;
    }
 
    /**
     * Set productService.
     *
     * @param $productService the value to be set
     */
    public function setProductService($productService)
    {
        $this->productService = $productService;
        return $this;
    }
 
    /**
     * Get availabilityService.
     *
     * @return availabilityService
     */
    public function getAvailabilityService()
    {
        return $this->availabilityService;
    }
 
    /**
     * Set availabilityService.
     *
     * @param $availabilityService the value to be set
     */
    public function setAvailabilityService($availabilityService)
    {
        $this->availabilityService = $availabilityService;
        return $this;
    }
}
