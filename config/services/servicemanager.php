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

        'catalog_product_mapper'           => function ($sm) {
            $mapper = new \Catalog\Mapper\Product;
            return $mapper->setDbAdapter($sm->get('catalog_db'));
        },
        'catalog_category_mapper'          => function ($sm) {
            $mapper = new \Catalog\Mapper\Category;
            return $mapper->setDbAdapter($sm->get('catalog_db'));
        },
        'catalog_company_mapper'           => function ($sm) {
            $mapper = new \Catalog\Mapper\Company;
            return $mapper->setDbAdapter($sm->get('catalog_db'));
        },
        'catalog_option_mapper'            => function ($sm) {
            $mapper = new \Catalog\Mapper\Option;
            return $mapper->setDbAdapter($sm->get('catalog_db'));
        },
        'catalog_choice_mapper'            => function ($sm) {
            $mapper = new \Catalog\Mapper\Choice;
            return $mapper->setDbAdapter($sm->get('catalog_db'));
        },
        'catalog_product_uom_mapper'       => function ($sm) {
            $mapper = new \Catalog\Mapper\ProductUom;
            return $mapper->setDbAdapter($sm->get('catalog_db'));
        },
        'catalog_image_mapper'             => function ($sm) {
            $mapper = new \Catalog\Mapper\Image;
            return $mapper->setDbAdapter($sm->get('catalog_db'));
        },
        'catalog_document_mapper'          => function ($sm) {
            $mapper = new \Catalog\Mapper\Document;
            return $mapper->setDbAdapter($sm->get('catalog_db'));
        },
        'catalog_uom_mapper'               => function ($sm) {
            $mapper = new \Catalog\Mapper\Uom;
            return $mapper->setDbAdapter($sm->get('catalog_db'));
        },
        'catalog_availability_mapper'      => function ($sm) {
            $mapper = new \Catalog\Mapper\Availability;
            return $mapper->setDbAdapter($sm->get('catalog_db'));
        },
        'catalog_spec_mapper'              => function ($sm) {
            $mapper = new \Catalog\Mapper\Spec;
            return $mapper->setDbAdapter($sm->get('catalog_db'));
        },
        'catalog_sites_mapper'              => function ($sm) {
            $mapper = new \Catalog\Mapper\Sites;
            return $mapper->setDbAdapter($sm->get('catalog_db'));
        },

        'catalog_db' => function ($sm) {
            return $sm->get('Zend\Db\Adapter\Adapter');
        },
    ),
);
