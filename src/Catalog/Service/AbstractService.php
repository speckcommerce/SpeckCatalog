<?php

namespace Catalog\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AbstractService implements ServiceLocatorAwareInterface
{
    protected $serviceLocator;

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

    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }
}
