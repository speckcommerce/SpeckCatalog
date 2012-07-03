<?php

namespace CatalogManager\Service;

use Catalog\Service\DocumentService as CatalogDocumentService;
use Zend\Stdlib\Hydrator\ClassMethods as Hydrator;

class DocumentService extends CatalogDocumentService
{
    public function getCatalogManagerForm($model = null)
    {
        $key = 'catalogmanager_document_form';

        $form = $this->getServiceManager()->get($key);
        $hydrator = new Hydrator();
        $data = $hydrator->extract($model);
        $form->setHydrator($hydrator);
        $form->bind($model);
        $form->setData($data);

        return $form;
    }
}
