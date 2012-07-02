<?php

namespace CatalogManager\Service;

use Catalog\Service\ProductService as CatalogProductService;
use Zend\Stdlib\Hydrator\ClassMethods as Hydrator;

class ProductService extends CatalogProductService
{
    public function getCatalogManagerForm($model = null)
    {
        $key = 'catalogmanager_product_form';

        $form = $this->getServiceManager()->get($key);
        $hydrator = new Hydrator();
        $data = $hydrator->extract($model);
        $form->setHydrator($hydrator);
        $form->bind($model);
        $form->setData($data);

        return $form;
    }
}
