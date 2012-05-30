<?php
return array(
    'router' => array(
        'routes' => array(
            'productshortcut' => array(
                'type' => 'Segment',
                'priority' => -1000,
                'options' => array(
                    'route' => '/:id',
                    'defaults' => array(
                        'controller' => 'Catalog\Controller\CatalogController',
                        'action' => 'productRedirect',
                    ),
                ),
            ),
            'catalog' => array(
                'type' => 'Literal',
                'priority' => 1000,
                'options' => array(
                    'route' => '/catalog',
                    'defaults' => array(
                        'controller' => 'Catalog\Controller\CatalogController',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => false,
                'child_routes' => array(  
                    'product' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/product/:id',
                            'defaults' => array(
                                'controller' => 'Catalog\Controller\CatalogController',
                                'action' => 'product',
                            ),
                        ),
                    ),
                ),
            ), 
            'catalogmanager' => array(
                'type' => 'Segment',
                'priority' => 1000,
                'options' => array(
                    'route' => '/catalogmanager',
                    'defaults' => array(
                        'controller' => 'CatalogManager\Controller\CatalogManagerController',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'new' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/new/:class[/:constructor]',
                            'defaults' => array(
                                'action' => 'new',
                            ),
                        ),
                    ),
                    'sort' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/sort/:type/:parent',
                            'defaults' => array(
                                'action' => 'sort',
                            ),
                        ),
                    ),
                    'remove' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/remove/:type/:linkerId',
                            'defaults' => array(
                                'action' => 'remove',
                            ),
                        ),
                    ),
                    'fetch-partial' => array(
                        'type'    => 'literal',
                        'options' => array(
                            'route'    => '/fetch-partial',
                            'defaults' => array(
                                'action' => 'fetchPartial',
                            ),
                        ),
                    ),
                    'products' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/products[/:page]',
                            'defaults' => array(
                                'action' => 'products',
                            ),
                        ),
                    ),
                    'product' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/product/:id',
                            'defaults' => array(
                                'action' => 'product',
                            ),
                        ),
                    ),
                    'categories' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/categories[/:page]',
                            'defaults' => array(
                                'action' => 'categories',
                            ),
                        ),
                    ),
                    'search-class' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/search-class',
                            'defaults' => array(
                                'action' => 'search-class',
                            ),
                        ),
                    ),
                    'update-record' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/update-record/:class/:id',
                            'defaults' => array(
                                'action' => 'update-record',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view'
        ), 
    ),
);      
