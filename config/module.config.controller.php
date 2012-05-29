<?php
return array(
    'controller' => array(
        'factories' => array(
            'CatalogManager\Controller\CatalogManagerController' => function($sm) {
                $controller = new CatalogManager\Controller\CatalogManagerController;
                $controller->setCatalogService($sm->get('catalog_generic_service'));
                
                $controller->setLinkerService($sm->get('catalog_model_linker_service'));
                return $controller;
            }
        ),
    ),   
);
