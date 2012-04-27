<?php
$config = array(
    'speck_catalog' => array(
        'install' => 'Catalog\Service\Installer',
    )
);

$configFiles = array(
    __DIR__ . '/module.config.di.php',
    __DIR__ . '/module.config.di.alias.php',
    __DIR__ . '/module.config.di.routes.php',
);

foreach($configFiles as $configFile) {
    $config = Zend\Stdlib\ArrayUtils::merge($config, include $configFile);
}

return $config;
