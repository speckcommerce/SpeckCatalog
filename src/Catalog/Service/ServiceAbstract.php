<?php

namespace Catalog\Service;
use Exception;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;

/**
 * ServiceAbstract
 */
abstract class ServiceAbstract implements ServiceInterface, ServiceManagerAwareInterface
{
    protected $modelMapper;
    protected $user;
    protected $serviceManager;

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }

    public function populateModel($model)
    {
        $model = $this->_populateModel($model);
        return $model;
    }

    public function getAll()
    {
        return $this->getModelMapper()->getAll();
    }

    public function getById($id, $populate=false, $recursive=false)
    {
        $model = $this->getModelMapper()->findById($id);
        if($model){
            if(true === $populate){
                $model = $this->populateModel($model, $recursive);
            }
            return $model;
        }
    }

    public function populateModels($models)
    {
        foreach($models as $i => $model){
            $models[$i] = $this->populateModel($model);
        }
        return $models;
    }

    public function updateModelFromArray($arr)
    {
        $model = $this->getModelMapper()->rowToModel($arr);
        return $this->update($model);
    }

    public function getModel($constructor=null)
    {
        return $this->getModelMapper()->getModel($constructor);
    }

    public function getModelsBySearchData($string)
    {
        return $this->getModelMapper()->getModelsBySearchData($string);
    }

    public function add($model)
    {
        return $this->getModelMapper()->add($model);
    }

    //array or model
    public function update($model)
    {
        $id = $this->getModelMapper()->update($model);
        return $this->getById($id);
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
    }

    public function dumpVarToString($var)
    {
        ob_start();
        var_dump($var);
        return ob_get_clean();
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

    public function getServiceManager()
    {
        return $this->serviceManager;
    }

}
