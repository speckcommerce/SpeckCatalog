<?php

namespace SpeckCatalog\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use SpeckCatalog\Model\AbstractModel;
use SpeckCatalog\Mapper\AbstractMapper;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;

class AbstractService implements ServiceLocatorAwareInterface, EventManagerAwareInterface
{
    use EventManagerAwareTrait;

    protected $serviceLocator;
    protected $enabledOnly = false;

    public function search(array $params)
    {
        return $this->getEntityMapper()->search($params);
    }

    public function find(array $data, $populate = false, $recursive = false)
    {
        $result = $this->getEntityMapper()->find($data);
        if (!$result) {
            return false;
        }
        if ($populate) {
            //$populate may be an array of things to populate
            $this->populate($result, $recursive, $populate);
        }
        return $result;
    }

    public function findRow(array $data)
    {
        return $this->getEntityMapper()->findRow($data);
    }

    public function findRows(array $data)
    {
        return $this->getEntityMapper()->findRows($data);
    }

    public function findMany(array $data, $populate = false, $recursive = false)
    {
        $result = $this->getEntityMapper()->findMany($data);
        if (!count($result)) {
            return false;
        }
        if ($populate) {
            foreach ($result as $res) {
                //$populate may be an array of things to populate
                $this->populate($res, $recursive, $populate);
            }
        }
        return $result;
    }

    public function populate($model, $recursive = false, $children = true)
    {
        return $model;
    }

    public function getModel($construct = null)
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

        if ($this->entityMapper instanceof AbstractMapper) {
            $this->entityMapper->setEnabledOnly($this->enabledOnly());
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
        return $this->getEntityMapper()->insert($model);
    }

    public function delete(array $where)
    {
        return $this->getEntityMapper()->delete($where);
    }

    public function usePaginator($options = array())
    {
        $this->getEntityMapper()->usePaginator($options);
        return $this;
    }

    public function setEnabledOnly($bool)
    {
        $this->enabledOnly = $bool;
        return $this;
    }

    public function enabledOnly()
    {
        return $this->enabledOnly;
    }
}
