<?php

namespace CatalogManager\Service;

use Catalog\Service\AvailabilityService as CatalogAvailabilityService;
use Zend\Stdlib\Hydrator\ClassMethods as Hydrator;

class AvailabilityService extends CatalogAvailabilityService
{
    public function getCatalogManagerForm($model = null)
    {
        $key = 'catalogmanager_availability_form';

        $form = $this->getServiceManager()->get($key);
        $hydrator = new Hydrator();
        $data = $hydrator->extract($model);
        $form->setHydrator($hydrator);
        $form->bind($model);
        $form->setData($data);

        return $form;
    }
}
