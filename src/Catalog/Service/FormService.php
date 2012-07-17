<?php

namespace Catalog\Service;

use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\Hydrator\ClassMethods as Hydrator;

class FormService implements ServiceManagerAwareInterface
{
    protected $serviceManager;

    protected $form;

    protected $catalogService;

    public function getForm($className = null, $model = null, $bind=true)
    {
        if(!$model){
            $model = $this->getCatalogService()->getModel($className);
        }

        $formName = 'catalog_' . $model->get('underscore_class_name') . '_form';
        $form = $this->getServiceManager()->get($formName);

        $filterName = 'catalog_' . $model->get('underscore_class_name') . '_form_filter';
        $filter = $this->getServiceManager()->get($filterName);
        $form->setInputFilter($filter);

        $form->setHydrator(new Hydrator);
        if($bind){
            $form->bind($model);
        }

        return $form;
    }

    public function prepare($className, $data)
    {
        $form = $this->getForm($className, null, false);
        $form->setData($data);

        $form->isValid();

        var_dump($form->getData()); die();

        return $form;
    }

    /**
     * Get serviceManager.
     *
     * @return serviceManager.
     */
    function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * Set serviceManager.
     *
     * @param serviceManager the value to set.
     */
    function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    /**
     * Get catalogService.
     *
     * @return catalogService.
     */
    function getCatalogService()
    {
        if(null === $this->catalogService){
            $this->catalogService = $this->getServiceManager()->get('catalog_generic_service');
        }
        return $this->catalogService;
    }

    /**
     * Set catalogService.
     *
     * @param catalogService the value to set.
     */
    function setCatalogService($catalogService)
    {
        $this->catalogService = $catalogService;
    }
}
