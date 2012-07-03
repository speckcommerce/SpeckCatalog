<?php

namespace CatalogManager\Service;

use Catalog\Service\ImageService as CatalogImageService;
use Zend\Stdlib\Hydrator\ClassMethods as Hydrator;

class ImageService extends CatalogImageService
{
    public function getCatalogManagerForm($model = null)
    {
        $key = 'catalogmanager_image_form';

        $form = $this->getServiceManager()->get($key);
        $hydrator = new Hydrator();
        $data = $hydrator->extract($model);
        $form->setHydrator($hydrator);
        $form->bind($model);
        $form->setData($data);

        return $form;
    }
}
