<?php
return array(
    'controller' => array(
        'factories' => array(
            'CatalogManager\Controller\CatalogManagerController' => function($sm) {
                return new CatalogManager\Controller\CatalogManagerController;
            }
        ),
    ),   
);
