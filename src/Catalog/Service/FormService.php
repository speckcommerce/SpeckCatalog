<?php

namespace Catalog\Service;

use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\Hydrator\ClassMethods as Hydrator;

class FormService implements ServiceManagerAwareInterface
{
    protected $serviceManager;


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
}
