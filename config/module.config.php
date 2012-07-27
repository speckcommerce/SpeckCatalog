<?php

use Catalog\Service\FormServiceAwareInterface;
use Catalog\Service\CatalogServiceAwareInterface;

$config = array(
    'controllers' => array(
        'invokables' => array(
            'catalog'         => 'Catalog\Controller\CatalogController',
            'catalogManager'  => 'Catalog\Controller\CatalogManagerController',
            'category'        => 'Catalog\Controller\CategoryController',
            'catalogcart'        => 'Catalog\Controller\CartController',
            'manage-category' => 'Catalog\Controller\ManageCategoryController',
        ),
        'initializers' => array(
            function($instance, $sm){
                if($instance instanceof FormServiceAwareInterface){
                    $formService = $sm->get('catalog_form_service');
                    $instance->setFormService($formService);
                }
            },
            function($instance, $sm){
                if($instance instanceof CatalogServiceAwareInterface){
                    $catalogService = $sm->get('catalog_generic_service');
                    $instance->setCatalogService($catalogService);
                }
            },
        ),
    ),
);

$configFiles = array(
    __DIR__ . '/module.config.routes.php',
);

foreach($configFiles as $configFile) {
    $config = Zend\Stdlib\ArrayUtils::merge($config, include $configFile);
}

return $config;
