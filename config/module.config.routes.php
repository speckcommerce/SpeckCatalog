<?php
return [
    'router' => [
        'routes' => [
            'index' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => 'speckcatalog_catalog',
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'productshortcut' => [
                        'type' => 'Segment',
                        'priority' => -1000,
                        'options' => [
                            'route' => ':id',
                            'constraints' => [
                                'id' => '\d+',
                            ],
                            'defaults' => [
                                'controller' => 'speckcatalog_catalog',
                                'action' => 'productRedirect',
                            ],
                        ],
                    ],
                ],
            ],
            'category' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/category',
                    'defaults' => [
                        'controller' => 'speckcatalog_category',
                        'action' => 'index',
                    ],
                ],
                'child_routes' => [
                    'byid' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/:id',
                            'constraints' => [
                                'id' => '[0-9]+',
                            ],
                        ],
                    ],
                ],
            ],
            'product' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/product',
                    'defaults' => [
                        'controller' => 'speckcatalog_product',
                        'action' => 'index',
                    ],
                ],
                'child_routes' => [
                    'byid' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/:id',
                            'constraints' => [
                                'id' => '[0-9]+',
                            ],
                        ],
                    ],
                    'images' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/images/:id',
                            'constraints' => [
                                'id' => '[0-9]+',
                            ],
                            'defaults' => [
                                'action' => 'images',
                            ],
                        ],
                    ],
                ],
            ],
            'partial/uoms' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/partial/uoms',
                    'defaults' => [
                        'controller' => 'speckcatalog_product',
                        'action' => 'uomsPartial'
                    ],
                ],
            ],
            'partial/options' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/partial/options',
                    'defaults' => [
                        'controller' => 'speckcatalog_product',
                        'action' => 'optionsPartial'
                    ],
                ],
            ],
            'catalog' => [
                'type' => 'Literal',
                'priority' => 1000,
                'options' => [
                    'route' => '/catalog',
                    'defaults' => [
                        'controller' => 'speckcatalog_catalog',
                        'action' => 'index',
                    ],
                ],
            ],
            'checkout' => [
                'type' => 'Literal',
                'priority' => 1000,
                'options' => [
                    'route' => '/checkout',
                    'defaults' => [
                        'controller' => 'speckcatalog_checkout',
                        'action' => 'index',
                    ],
                ],
            ],
            'zfcadmin' => [
                'child_routes' => [
                    'catalogmanager' => [
                        'type' => 'Segment',
                        'priority' => 1000,
                        'options' => [
                            'route' => '/catalogmanager',
                            'defaults' => [
                                'controller' => 'speckcatalog_manager',
                                'action' => 'index',
                            ],
                        ],
                        'may_terminate' => false,
                        'child_routes' => [
                            'new-product' => [
                                'type'    => 'Literal',
                                'options' => [
                                    'route'    => '/new-product',
                                    'defaults' => [
                                        'action' => 'newProduct',
                                    ],
                                ],
                            ],
                            'sort' => [
                                'type'    => 'Segment',
                                'options' => [
                                    'route'    => '/sort/:parent/:type',
                                    'defaults' => [
                                        'action' => 'sort',
                                    ],
                                ],
                            ],
                            'remove-child' => [
                                'type'    => 'Segment',
                                'options' => [
                                    'route'    => '/remove-child',
                                    'defaults' => [
                                        'action' => 'removeChild',
                                    ],
                                ],
                            ],
                            'new-partial' => [
                                'type'    => 'literal',
                                'options' => [
                                    'route'    => '/new-partial',
                                    'defaults' => [
                                        'action' => 'newPartial',
                                    ],
                                ],
                            ],
                            'find' => [
                                'type'    => 'literal',
                                'options' => [
                                    'route'    => '/find',
                                    'defaults' => [
                                        'action' => 'find',
                                    ],
                                ],
                            ],
                            'found' => [
                                'type'    => 'literal',
                                'options' => [
                                    'route'    => '/found',
                                    'defaults' => [
                                        'action' => 'found',
                                    ],
                                ],
                            ],
                            'products' => [
                                'type'    => 'Literal',
                                'options' => [
                                    'route'    => '/products',
                                    'defaults' => [
                                        'action' => 'products',
                                    ],
                                ],
                            ],
                            'company' => [
                                'type'    => 'Segment',
                                'options' => [
                                    'route'    => '/company/:id',
                                    'defaults' => [
                                        'action' => 'company',
                                    ],
                                ],
                            ],
                            'companies' => [
                                'type'    => 'Segment',
                                'options' => [
                                    'route'    => '/companies[/:page]',
                                    'defaults' => [
                                        'action' => 'companies',
                                    ],
                                ],
                            ],
                            'product' => [
                                'type'    => 'Segment',
                                'options' => [
                                    'route'    => '/product/:id',
                                    'defaults' => [
                                        'action' => 'product',
                                    ],
                                ],
                            ],
                            'categories' => [
                                'type'    => 'Literal',
                                'options' => [
                                    'route'    => '/categories',
                                    'defaults' => [
                                        'action' => 'categories',
                                    ],
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'search' => [
                                        'type'    => 'Segment',
                                        'options' => [
                                            'route'    => '/search/:type/:terms',
                                            'defaults' => [
                                                'action' => 'categorySearchChildren',
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                            'search-class' => [
                                'type' => 'Literal',
                                'options' => [
                                    'route' => '/search-class',
                                    'defaults' => [
                                        'action' => 'search-class',
                                    ],
                                ],
                            ],
                            'update-form' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/update-form/:class',
                                    'defaults' => [
                                        'action' => 'update-form',
                                    ],
                                ],
                            ],
                            'update-record' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/update-record/:class',
                                    'defaults' => [
                                        'action' => 'update-record',
                                    ],
                                ],
                            ],
                            'update-product' => [
                                'type' => 'Literal',
                                'options' => [
                                    'route' => '/update-product',
                                    'defaults' => [
                                        'action' => 'update-product',
                                    ],
                                ],
                            ],
                            'category-tree-preview' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/category-tree-preview/:siteid',
                                    'defaults' => [
                                        'action' => 'categoryTreePreview',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view'
        ],
    ],
];
