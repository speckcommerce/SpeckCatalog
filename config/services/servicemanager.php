<?php
return array(
    'shared' => array(
    ),
    'factories' => array(
        'speckcatalog_product_image_service' => function ($sm) {
            $service = new \SpeckCatalog\Service\Image;
            $mapper = $sm->get('speckcatalog_image_mapper')->setParentType('product');
            return $service->setEntityMapper($mapper);
        },
        'speckcatalog_option_image_service' => function ($sm) {
            $service = new \SpeckCatalog\Service\Image;
            $mapper = $sm->get('speckcatalog_image_mapper')->setParentType('option');
            return $service->setEntityMapper($mapper);
        },
        'speckcatalog_module_options' => function ($sm) {
            $config = $sm->get('Config');
            return new \SpeckCatalog\Options\ModuleOptions(isset($config['speckcatalog']) ? $config['speckcatalog'] : array());
        },
        'speckcatalog_availability_form' => function ($sm) {
            $form = new \SpeckCatalog\Form\Availability;
            $form->setCompanyService($sm->get('speckcatalog_company_service'));
            return $form->init();
        },
        'speckcatalog_product_form' => function ($sm) {
            $form = new \SpeckCatalog\Form\Product;
            $companyService = $sm->get('speckcatalog_company_service');
            $form->setCompanyService($sm->get('speckcatalog_company_service'));
            return $form->init();
        },
        'speckcatalog_product_uom_form' => function ($sm) {
            $form = new \SpeckCatalog\Form\ProductUom;
            $form->setUomService($sm->get('speckcatalog_uom_service'));
            return $form->init();
        },
    ),
    'aliases' => array(
        'speckcatalog_db' => 'Zend\Db\Adapter\Adapter',
    )
);
