<?php
namespace Catalog\Service;
class ModelLinkerService
{
    protected $model;
    protected $class;
    protected $new = false;
    protected $id;
    protected $parentClassName;
    protected $parentId;
    protected $childClassName;
    protected $childId;
    protected $catalogService;

    public function setData($data)
    {
        if (trim($data['new_class_name'])){
            $this->new = true;
            $this->class = $data['new_class_name'];
        }else{
            $this->class = $data['class_name'];
        }
        $this->parentClassName = $data['parent_class_name'];
        $this->parentId        = $data['parent_id'];
        if (isset($data['id']) && trim($data['id'])){
            $this->id =  $data['id'];
        }
        if (isset($data['child_class_name']) && trim($data['child_class_name'])){
            $this->childClassName =  $data['child_class_name'];
        }
        if (isset($data['child_id']) && trim($data['child_id'])){
            $this->childId = $data['child_id'];
        }
    }

    public function linkModel($data)
    {
        $this->setData($data);
        if (false === $this->new){
            $this->model = $this->getExistingModel();
            return $this->createLinker($this->class, $this->id, $this->parentClassName, $this->parentId);
        }
        $this->model = $this->getModelService()->getModel();
        $this->model = $this->resolveAndStoreRelationship();
        if ($this->childClassName && $this->childId){
            $this->createLinker($this->childClassName, $this->childId, $this->class, $model->getId());
        }   
        return $this->model;
    }

    public function resolveAndStoreRelationship()
    {
        // one/many children to one parent
        $setParentClassId = 'setParent' . ucfirst($this->parentClassName) . 'Id';
        if (is_callable(array($this->model, $setParentClassId))){
            $this->model->$setParentClassId($this->parentId);
            return $this->getModelService()->add($this->model);
        } 
        // one/many parents to one child
        $setChildClassId = 'set' . ucfirst($this->class) . 'Id';
        $parentModelService = $this->getModelService($this->parentClassName);
        $parentModel = $parentModelService->getById($this->parentId);
        if (is_callable(array($parentModel, $setChildClassId))){
            $parentModelService->update($parentModel->$setChildClassId($id));
            return $this->model;
        }
        // many parents to many children
        $this->getModelService()->add($this->model);
        return $this->createLinker($this->class, $this->model->getRecordId(), $this->parentClassName, $this->parentId);
    }

    public function createLinker($className, $id, $parentClassName, $parentId)
    {
        $method = 'linkParent' . ucfirst($parentClassName);
        if (is_callable(array($this->getModelService($className), $method))){
            $linkerId = $this->getModelService($className)->$method($parentId, $id);
            return $this->model->setLinkerId($linkerId);
        } 
        throw new \Exception('uh oh');  
    }

    public function removeLinker($class, $linkerId)
    {
        var_dump($this->getModelService($class)->removeLinker($linkerId));
        //todo: check for orphan records....
    }    

    public function getModelService($class=null)
    {
        if (null === $class){
            $class = $this->class;
        }
        return $this->getCatalogService()->getModelService($class);
    }

    public function getCatalogService()
    {
        return $this->catalogService;
    }

    public function setCatalogService($catalogService)
    {
        $this->catalogService = $catalogService;
        return $this;
    }
}
