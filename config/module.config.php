<?php
return array(
    'layout' => 'layouts/catalog-manage.phtml',
    'di' => array(
        'instance' => array(
            'alias' => array(
                'catalog'                    => 'SpeckCatalog\Controller\IndexController',
                'catalogmanager'              => 'SpeckCatalogManager\Controller\IndexController',
                'catalog_manager_service' => 'SpeckCatalogManager\Service\CatalogManagerService',
            ),
            'catalogmanager' => array(
                'parameters' => array(
                    'userService'    => 'speckcatalog_user_service',
                    'catalogManagerService' => 'catalog_manager_service',
                ),
            ),
            'Zend\View\PhpRenderer' => array(
                'parameters' => array(
                    'options'  => array(
                        'script_paths' => array(
                            'SwmBase' => __DIR__ . '/../views',
                        ),
                    ),
                ),
            ), 
             'doctrine_driver_chain' => array(
                'parameters' => array(
                    'drivers' => array(
                        'speckcatalog_annotationdriver' => array(
                            'class'           => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                            'namespace'       => 'Catalog\Entity',
                            'paths'           => array(__DIR__ . '/../src/Catalog/Entity'),
                        ),
                    ),
                )
            ),         
        ),
    ),
);
