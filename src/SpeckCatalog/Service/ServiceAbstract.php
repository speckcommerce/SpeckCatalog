<?php

namespace SpeckCatalog\Service;
    use Exception;

class ServiceAbstract
{
    protected $modelMapper;
    protected $user; 
    
    
    public function getAll()
    {
        return $this->modelMapper->getAll();
    }

    public function getModelById($id, $populate=true)
    {
        $model = $this->modelMapper->getModelById($id);
        if(true === $populate){
            return $this->populateModel($model);
        }else{
            return $model;
        }
    }
    
    public function updateModelFromArray($arr)
    {
        $model = $this->modelMapper->instantiateModel($arr);
        return $this->modelMapper->update($model)->toArray();
    }    
    
    public function newModel($constructor)
    {
        return $this->getModelMapper()->newModel($constructor);
    }

    public function getModelsBySearchData($string)
    {
        return $this->getModelMapper()->getModelsBySearchData($string);
    }

    public function add($model)
    {
        $this->getModelMapper()->add($model);
    }
    
    public function update($model)
    {
        $this->getModelMapper()->update($model);
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
        if($this->modelMapper){
            return $this->modelMapper;
        }else{
            $class = get_class($this);
            throw new exception("Please check this modules DI config for {$class} modelMapper, currently none exists, or there was an error");
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
