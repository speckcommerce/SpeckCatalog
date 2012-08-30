<?php

namespace Catalog\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods as Hydrator;

class FormService implements ServiceLocatorAwareInterface
{
    protected $serviceLocator;

    protected $form;

    public function getForm($name = null, $model = null, $bind=true)
    {
        if(!$model){
            $serviceName = 'catalog_' . $name . '_service';
            $model = $this->getServiceLocator()->get($serviceName)->getModel($className);
        }

        $formName = 'catalog_' . $name . '_form';
        $form = $this->getServiceLocator()->get($formName);

        $filterName = 'catalog_' . $name . '_form_filter';
        $filter = $this->getServiceLocator()->get($filterName);
        $form->setInputFilter($filter);

        $form->setHydrator(new Hydrator);
        if($bind){
            $form->bind($model);
        }

        return $form;
    }

    public function prepare($name, $data)
    {
        $form = $this->getForm($name, null, false);
        $form->setData($data);

        return $form;
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
