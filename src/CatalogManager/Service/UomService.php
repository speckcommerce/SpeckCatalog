<?php

namespace CatalogManager\Service;

use Catalog\Service\UomService as CatalogUomService;
use Zend\Stdlib\Hydrator\ClassMethods as Hydrator;

class UomService extends CatalogUomService
{
    public function getCatalogManagerForm($model = null)
    {
        $key = 'catalogmanager_uom_form';

        $form = $this->getServiceManager()->get($key);
        $hydrator = new Hydrator();
        $data = $hydrator->extract($model);
        $form->setHydrator($hydrator);
        $form->bind($model);
        $form->setData($data);

        return $form;
    }
}
