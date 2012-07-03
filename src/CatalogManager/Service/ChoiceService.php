<?php

namespace CatalogManager\Service;

use Catalog\Service\ChoiceService as CatalogChoiceService;
use Zend\Stdlib\Hydrator\ClassMethods as Hydrator;

class ChoiceService extends CatalogChoiceService
{
    public function getCatalogManagerForm($model = null)
    {
        $key = 'catalogmanager_choice_form';

        $form = $this->getServiceManager()->get($key);
        $hydrator = new Hydrator();
        $data = $hydrator->extract($model);
        $form->setHydrator($hydrator);
        $form->bind($model);
        $form->setData($data);

        return $form;
    }
}
