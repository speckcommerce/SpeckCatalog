<?php
return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'catalogmanage' => 'Management\Controller\IndexController',
                'catalog_management_service' => 'Management\Service\CatalogManagementService',
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
        ),
    ),
);
