<?php
return array(
    'shared' => array(
    ),
    'factories' => array(
        'catalog_product_image_service' => function ($sm) {
            $service = new \Catalog\Service\Image;
            $mapper = $sm->get('catalog_image_mapper')->setParentType('product');
            return $service->setEntityMapper($mapper);
        },
        'catalog_option_image_service' => function ($sm) {
            $service = new \Catalog\Service\Image;
            $mapper = $sm->get('catalog_image_mapper')->setParentType('option');
            return $service->setEntityMapper($mapper);
        },
        'catalog_module_options' => function ($sm) {
            $config = $sm->get('Config');
            return new \Catalog\Options\ModuleOptions(isset($config['speckcatalog']) ? $config['speckcatalog'] : array());
        },
        'catalog_availability_form' => function ($sm) {
            $form = new \Catalog\Form\Availability;
            $form->setCompanyService($sm->get('catalog_company_service'));
            return $form->init();
        },
        'catalog_product_form' => function ($sm) {
            $form = new \Catalog\Form\Product;
            $companyService = $sm->get('catalog_company_service');
            $form->setCompanyService($sm->get('catalog_company_service'));
            return $form->init();
        },
        'catalog_product_uom_form' => function ($sm) {
            $form = new \Catalog\Form\ProductUom;
            $form->setUomService($sm->get('catalog_uom_service'));
            return $form->init();
        },
        'catalog_db' => function ($sm) {
            return $sm->get('Zend\Db\Adapter\Adapter');
        },
    ),
);
