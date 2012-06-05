<?php
$config = array(
    'controller' => array(
        'classes' => array(
            'catalogmanager' => 'CatalogManager\Controller\CatalogManagerController'
        ),
    ), 
);

$configFiles = array(
    __DIR__ . '/module.config.routes.php',
    __DIR__ . '/module.config.db.php',
);

foreach($configFiles as $configFile) {
    $config = Zend\Stdlib\ArrayUtils::merge($config, include $configFile);
}

return $config;
