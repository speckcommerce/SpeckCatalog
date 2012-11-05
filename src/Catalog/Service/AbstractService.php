<?php

namespace Catalog\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Catalog\Model\AbstractModel;

class AbstractService implements ServiceLocatorAwareInterface
{
    protected $serviceLocator;

    public function find(array $data, $populate=false, $recursive=false)
    {
        return $this->getEntityMapper()->find($data);
    }

    public function populate($model, $recursive=false)
    {
        return $model;
    }

    public function getEntity()
    {
        return $this->getEntityMapper()->getEntityPrototype();
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

    public function update($formData, $originalValues)
    {
        return $this->getEntityMapper()->update($formData, $originalValues);
    }

    public function insert($model)
    {
        return $this->getEntityMapper()->insert($model);
    }

    public function usePaginator($options=array())
    {
        $this->getEntityMapper()->usePaginator($options);
        return $this;
    }

    public function getPaginator()
    {
        return $this->paginator;
    }

    public function setPaginator($paginator)
    {
        $this->paginator = $paginator;
        return $this;
    }
}
