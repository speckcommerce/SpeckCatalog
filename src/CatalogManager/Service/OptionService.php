<?php

namespace CatalogManager\Service;

use Catalog\Service\OptionService as CatalogOptionService;
use Zend\Stdlib\Hydrator\ClassMethods as Hydrator;

class OptionService extends CatalogOptionService
{
    public function getCatalogManagerForm($model = null)
    {
        $key = 'catalogmanager_option_form';

        $form = $this->getServiceManager()->get($key);
        $hydrator = new Hydrator();
        $data = $hydrator->extract($model);
        $form->setHydrator($hydrator);
        $form->bind($model);
        $form->setData($data);

        return $form;
    }
}
