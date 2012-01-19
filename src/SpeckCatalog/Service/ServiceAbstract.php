<?php

namespace SpeckCatalog\Service;

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
        return $this->modelMapper->newModel($constructor);
    }

    public function getModelsBySearchData($string)
    {
        return $this->modelMapper->getModelsBySearchData($string);
    }

    public function add($model)
    {
        $this->modelMapper->add($model);
    }
    
    public function update($model)
    {
        $this->modelMapper->update($model);
    }

    public function setModelMapper($modelMapper)
    {
        $this->modelMapper = $modelMapper;
        return $this;
    }

    public function getModelMapper()
    {
        return $this->modelMapper;
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
