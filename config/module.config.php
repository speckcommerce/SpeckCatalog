<?php

use Catalog\Service\FormServiceAwareInterface;

$config = array(
    'controllers' => array(
        'invokables' => array(
            'catalog' => 'Catalog\Controller\CatalogController'
        ),
        'factories' => array(
            'catalogmanager' => function ($sm) {
                //$userAuth = $sm->get('zfcUserAuthentication');
                //$controller = new \Catalog\Controller\CatalogManagerController($userAuth);
                $controller = new \Catalog\Controller\CatalogManagerController();
                return $controller;
            },

        ),
        'initializers' => array(
            function($instance, $sm){
                if($instance instanceof FormServiceAwareInterface){
                    $formService = $sm->get('catalog_form_service');
                    $instance->setFormService($formService);
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
