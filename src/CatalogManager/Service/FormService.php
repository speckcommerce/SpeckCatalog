<?php

namespace CatalogManager\Service;

use Zend\ServiceManager\ServiceManagerAwareInterface,
    Zend\ServiceManager\ServiceManager,
    Zend\Stdlib\Hydrator\ClassMethods as Hydrator;

class FormService implements ServiceManagerAwareInterface
{
    protected $serviceManager;
    protected $hydrator;
    protected $model;
    protected $catalogService;

    public function getForm($formName, $domainModel)
    {
        $key = 'catalogmanager_' . $formName . '_form';
        $form = $this->getServiceManager()->get($key);

        $data = $this->getHydrator()->extract($domainModel);

        $form->setHydrator($this->getHydrator());
        $form->bind($domainModel);
        $form->setData($data);

        return $form;
    }

    public function formDataToModel($formName, $data)
    {
        $model = $this->model;
        $key = 'catalogmanager_' . $formName . '_form';
        $form = $this->getServiceManager()->get($key);
        $form->setHydrator($this->getHydrator());
        $form->bind($model);
        $form->setData($data);
        if (!$form->isValid()) {
            return false;
        }
        return $form->getData();
    }

    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }
    public function getHydrator()
    {
        if(null === $this->hydrator){
            $this->hydrator = new Hydrator();
        }
        return $this->hydrator;
    }

    public function getCatalogService()
    {
        if(null === $this->catalogService)
        {
            $this->catalogService = $this->getServiceManager()->get('catalog_generic_service');
        }
        return $this->catalogService;
    }

    public function setCatalogService($catalogService)
    {
        $this->catalogService = $catalogService;
        return $this;
    }


}
