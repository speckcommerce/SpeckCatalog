<?php
return [
    'shared' => [
        'speckcatalog_image_mapper' => false,
    ],
    'factories' => [
        'speckcatalog_category_service'     => function ($sm) {
            $service = new \SpeckCatalog\Service\Category;
            $domain  = $sm->get('multisite_domain_data');
            $service->setSiteId($domain['website_id']);
            return $service->setSiteId($domain['website_id']);
        },
        'speckcatalog_product_image_service' => function ($sm) {
            $service = new \SpeckCatalog\Service\Image;
            $mapper  = $sm->get('speckcatalog_image_mapper')->setParentType('product');
            return $service->setEntityMapper($mapper);
        },
        'speckcatalog_option_image_service' => function ($sm) {
            $service = new \SpeckCatalog\Service\Image;
            $mapper  = $sm->get('speckcatalog_image_mapper')->setParentType('option');
            return $service->setEntityMapper($mapper);
        },
        'speckcatalog_module_options' => function ($sm) {
            $config = $sm->get('Config');
            return new \SpeckCatalog\Options\ModuleOptions(isset($config['speckcatalog']) ? $config['speckcatalog'] : []);
        },
        'speckcatalog_availability_form' => function ($sm) {
            $form = new \SpeckCatalog\Form\Availability;
            $form->setCompanyService($sm->get('speckcatalog_company_service'));
            return $form->init();
        },
        'speckcatalog_product_form' => function ($sm) {
            $form = new \SpeckCatalog\Form\Product;
            $form->setCompanyService($sm->get('speckcatalog_company_service'));
            return $form->init();
        },
        'speckcatalog_product_uom_form' => function ($sm) {
            $form = new \SpeckCatalog\Form\ProductUom;
            $form->setUomService($sm->get('speckcatalog_uom_service'));
            return $form->init();
        },
    ],
    'aliases' => [
        'speckcatalog_db' => 'Zend\Db\Adapter\Adapter',
    ],
    'initializers' => [
        function ($instance, $sm) {
            if ($instance instanceof \SpeckCatalog\Mapper\DbAdapterAwareInterface) {
                $dbAdapter = $sm->get('speckcatalog_db');
                $instance->setDbAdapter($dbAdapter);
            }
        },
    ],
];
