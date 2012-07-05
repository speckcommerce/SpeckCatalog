<?php

namespace Catalog\Service;
use Exception;
use Zend\Stdlib\Hydrator\ClassMethods as Hydrator;
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

    public function getForm($className = null, $model)
    {
        $formName = 'catalog_' . $className . '_form';
        $form = $this->getServiceManager()->get($formName);
        $hydrator = new Hydrator();
        $data = $hydrator->extract($model);
        $form->setHydrator($hydrator);
        $form->bind($model);
        $form->setData($data);

        return $form;
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

    public function update($model)
    {
        $this->getModelMapper()->update($model);
        return $this->getById($model->getRecordId());
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
