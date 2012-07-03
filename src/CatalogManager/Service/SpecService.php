<?php

namespace CatalogManager\Service;

use Catalog\Service\Spec as CatalogSpec;
use Zend\Stdlib\Hydrator\ClassMethods as Hydrator;

class Spec extends CatalogSpec
{
    public function getCatalogManagerForm($model = null)
    {
        $key = 'catalogmanager_spec_form';

        $form = $this->getServiceManager()->get($key);
        $hydrator = new Hydrator();
        $data = $hydrator->extract($model);
        $form->setHydrator($hydrator);
        $form->bind($model);
        $form->setData($data);

        return $form;
    }
}
