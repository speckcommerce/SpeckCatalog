<?php

$rootPath  = realpath(dirname(__DIR__));
$testsPath = "$rootPath/test";

if (is_readable($testsPath . '/TestConfiguration.php')) {
    require_once $testsPath . '/TestConfiguration.php';
} else {
    require_once $testsPath . '/TestConfiguration.php.dist';
}

$path = array(
    $testsPath,
    ZEND_FRAMEWORK_PATH,
    get_include_path(),
);
set_include_path(implode(PATH_SEPARATOR, $path));

require_once 'Zend/Loader/AutoloaderFactory.php';
\Zend\Loader\AutoloaderFactory::factory(array('Zend\Loader\StandardAutoloader' => array()));

$moduleLoader = new \Zend\Loader\ModuleAutoloader(array(
    realpath(__DIR__ . '/../..'),
));
$moduleLoader->register();

$moduleManager = new \Zend\Module\Manager(array('SwmBase'));
$moduleManager->loadModule('SwmBase');

$config = $moduleManager->getMergedConfig(false);

$di = new \Zend\Di\Di;
$di->instanceManager()->addTypePreference('Zend\Di\Locator', $di);

$config = new \Zend\Di\Configuration($config['di']);
$config->configure($di);
