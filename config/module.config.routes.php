<?php
return array(
    'router' => array(
        'routes' => array(
            'productshortcut' => array(
                'type' => 'Segment',
                'priority' => -1000,
                'options' => array(
                    'route' => '/:id',
                    'constraints' => array(
                        'id' => '\d+',
                    ),
                    'defaults' => array(
                        'controller' => 'catalog',
                        'action' => 'productRedirect',
                    ),
                ),
            ),
            'category' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/category/:id',
                    'defaults' => array(
                        'controller' => 'category',
                        'action' => 'index',
                    ),
                ),
            ),
            'product' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/product/:id',
                    'defaults' => array(
                        'controller' => 'product',
                        'action' => 'index',
                    ),
                ),
            ),
            'catalog' => array(
                'type' => 'Literal',
                'priority' => 1000,
                'options' => array(
                    'route' => '/catalog',
                    'defaults' => array(
                        'controller' => 'catalog',
                        'action' => 'index',
                    ),
                ),
            ),
            'cart' => array(
                'type' => 'Literal',
                'priority' => 1000,
                'options' => array(
                    'route' => '/cart',
                    'defaults' => array(
                        'controller' => 'catalogcart',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'add-item' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/add-item[/:id]',
                            'defaults' => array(
                                'controller' => 'catalogcart',
                                'action' => 'addItem',
                            ),
                        ),
                    ),
                    'update-quantities' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/update-quantities',
                            'defaults' => array(
                                'controller' => 'catalogcart',
                                'action' => 'updateQuantities',
                            ),
                        ),
                    ),
                    'remove-item' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/remove-item/:id',
                            'defaults' => array(
                                'controller' => 'catalogcart',
                                'action' => 'remove-item',
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
                        'controller' => 'catalogmanager',
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
                    'company' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/company/:id',
                            'defaults' => array(
                                'action' => 'company',
                            ),
                        ),
                    ),
                    'companies' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/companies[/:page]',
                            'defaults' => array(
                                'action' => 'companies',
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
