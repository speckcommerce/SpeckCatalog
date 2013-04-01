<?php

namespace SpeckCatalog\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use SpeckCatalog\Model\AbstractModel;

class AbstractService implements ServiceLocatorAwareInterface
{
    protected $serviceLocator;

    public function search($str)
    {
        return $this->getEntityMapper()->search($str);
    }

    public function find(array $data, $populate=false, $recursive=false)
    {
        return $this->getEntityMapper()->find($data);
    }

    public function findRow(array $data)
    {
        return $this->getEntityMapper()->findRow($data);
    }

    public function populate($model, $recursive=false)
    {
        return $model;
    }

    public function getModel($construct=null)
    {
        return $this->getEntityMapper()->getModel($construct);
    }

    public function getAll()
    {
        return $this->getEntityMapper()->getAll();
    }

    public function getEntityMapper()
    {
        if (is_string($this->entityMapper) && strstr($this->entityMapper, '_mapper')) {
            $this->entityMapper = $this->getServiceLocator()->get($this->entityMapper);
        }
        return $this->entityMapper;
    }

    public function setEntityMapper($entityMapper)
    {
        $this->entityMapper = $entityMapper;
        return $this;
    }

    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

    public function update($dataOrModel, array $originalValues = null)
    {
        return $this->getEntityMapper()->update($dataOrModel, $originalValues);
    }

    public function insert($model)
    {
        $result = $this->getEntityMapper()->insert($model);
        $this->populate($result, true);
        return $result;
    }

    public function delete(array $where)
    {
        return $this->getEntityMapper()->delete($where);
    }

    public function usePaginator($options=array())
    {
        $this->getEntityMapper()->usePaginator($options);
        return $this;
    }
}
