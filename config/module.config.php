<?php
$config = array(
    'controllers' => array(
        'invokables' => array(
            'catalog' => 'Catalog\Controller\CatalogController'
        ),
        'factories' => array(
            'catalogmanager' => function ($sm) {
                //$userAuth = $sm->get('zfcUserAuthentication');
                //$controller = new \Catalog\Controller\CatalogManagerReduxController($userAuth);
                $controller = new \Catalog\Controller\CatalogManagerReduxController();
                return $controller;
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
