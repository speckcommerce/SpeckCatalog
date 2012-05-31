<?php
$config = array();

$configFiles = array(
    __DIR__ . '/module.config.controller.php',
    __DIR__ . '/module.config.routes.php',
    __DIR__ . '/module.config.db.php',
);

foreach($configFiles as $configFile) {
    $config = Zend\Stdlib\ArrayUtils::merge($config, include $configFile);
}

return $config;
