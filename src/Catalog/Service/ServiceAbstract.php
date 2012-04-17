<?php

namespace Catalog\Service;
    use Exception;

/**
 * ServiceAbstract 
 */
abstract class ServiceAbstract implements ServiceInterface
{
    protected $modelMapper;
    protected $user; 
    
    public function getAll()
    {
        return $this->getModelMapper()->getAll();
    }

    public function getById($id, $populate=true)
    {
        $model = $this->getModelMapper()->getById($id);
        if($model){
            if(true === $populate){
                $model = $this->populateModel($model);
            }
            return $model;
        }
    }
    
    public function updateModelFromArray($arr)
    {
        $model = $this->getModelMapper()->mapModel($arr);
        return $this->update($model);
    }    
    
    public function newModel($constructor=null)
    {
        return $this->getModelMapper()->newModel($constructor);
    }

    public function getModelsBySearchData($string)
    {
        return $this->getModelMapper()->getModelsBySearchData($string);
    }

    public function add($model)
    {
        return $this->getModelMapper()->add($model);
    }
    
    public function update($model)
    {
        $this->getModelMapper()->update($model);
        return $this->getById($model->getId());  
    }

    public function removeLinker($linkerId)
    {
        return $this->getModelMapper()->removeLinker($linkerId);
    }

    public function delete($modelId)
    {
        return $this->getModelMapper()->deleteById($modelId);
    }

    public function setModelMapper($modelMapper)
    {
        $this->modelMapper = $modelMapper;
        return $this;
    }

    public function getModelMapper()
    {
        if($this->modelMapper InstanceOf \Catalog\Model\Mapper\ModelMapperAbstract){
            return $this->modelMapper;
        }else{
            var_dump($this->modelMapper);
            throw new Exception('not instance of ModelMapperAbstract');
        }
    }     
 
    public function getUser()
    {
        return $this->user;
    }
 
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

}
