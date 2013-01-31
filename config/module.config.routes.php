<?php
return array(
    'router' => array(
        'routes' => array(
            'index' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'speckcatalog_catalog',
                        'action' => 'index',
                    ),
                ),
            ),
            'productshortcut' => array(
                'type' => 'Segment',
                'priority' => -1000,
                'options' => array(
                    'route' => '/:id',
                    'constraints' => array(
                        'id' => '\d+',
                    ),
                    'defaults' => array(
                        'controller' => 'speckcatalog_catalog',
                        'action' => 'productRedirect',
                    ),
                ),
            ),
            'category' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/category/:id',
                    'defaults' => array(
                        'controller' => 'speckcatalog_category',
                        'action' => 'index',
                    ),
                ),
                //'child_routes' => array(
                //    'per-page' => array(
                //        'type'    => 'Segment',
                //        'options' => array(
                //            'route'    => '/per-page',
                //            'defaults' => array(
                //                'controller' => 'speckcatalog_category',
                //                'action' => 'perPage',
                //            ),
                //        ),
                //    ),
                //),
            ),
            'product' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/product/:id[/:cartItemId]',
                    'defaults' => array(
                        'controller' => 'speckcatalog_product',
                        'action' => 'index',
                    ),
                ),
            ),
            'partial/uoms' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/partial/uoms',
                    'defaults' => array(
                        'controller' => 'speckcatalog_product',
                        'action' => 'uomsPartial'
                    ),
                ),
            ),
            'partial/options' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/partial/options',
                    'defaults' => array(
                        'controller' => 'speckcatalog_product',
                        'action' => 'optionsPartial'
                    ),
                ),
            ),
            'catalog' => array(
                'type' => 'Literal',
                'priority' => 1000,
                'options' => array(
                    'route' => '/catalog',
                    'defaults' => array(
                        'controller' => 'speckcatalog_catalog',
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
                        'controller' => 'speckcatalog_cart',
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
                                'controller' => 'speckcatalog_cart',
                                'action' => 'addItem',
                            ),
                        ),
                    ),
                    'update-quantities' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/update-quantities',
                            'defaults' => array(
                                'controller' => 'speckcatalog_cart',
                                'action' => 'updateQuantities',
                            ),
                        ),
                    ),
                    'remove-item' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/remove-item/:id',
                            'defaults' => array(
                                'controller' => 'speckcatalog_cart',
                                'action' => 'remove-item',
                            ),
                        ),
                    ),
                    'update-product' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/update-product',
                            'defaults' => array(
                                'controller' => 'speckcatalog_cart',
                                'action' => 'update-product',
                            ),
                        ),
                    ),
                ),
            ),
            'checkout' => array(
                'type' => 'Literal',
                'priority' => 1000,
                'options' => array(
                    'route' => '/checkout',
                    'defaults' => array(
                        'controller' => 'speckcatalog_checkout',
                        'action' => 'index',
                    ),
                ),
            ),
            'catalogmanager' => array(
                'type' => 'Segment',
                'priority' => 1000,
                'options' => array(
                    'route' => '/catalogmanager',
                    'defaults' => array(
                        'controller' => 'speckcatalog_manager',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'new-product' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/new-product',
                            'defaults' => array(
                                'action' => 'newProduct',
                            ),
                        ),
                    ),
                    'sort' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/sort/:parent/:type',
                            'defaults' => array(
                                'action' => 'sort',
                            ),
                        ),
                    ),
                    'remove-child' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/remove-child',
                            'defaults' => array(
                                'action' => 'removeChild',
                            ),
                        ),
                    ),
                    'new-partial' => array(
                        'type'    => 'literal',
                        'options' => array(
                            'route'    => '/new-partial',
                            'defaults' => array(
                                'action' => 'newPartial',
                            ),
                        ),
                    ),
                    'find' => array(
                        'type'    => 'literal',
                        'options' => array(
                            'route'    => '/find',
                            'defaults' => array(
                                'action' => 'find',
                            ),
                        ),
                    ),
                    'found' => array(
                        'type'    => 'literal',
                        'options' => array(
                            'route'    => '/found',
                            'defaults' => array(
                                'action' => 'found',
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
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/categories',
                            'defaults' => array(
                                'action' => 'categories',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'search' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/search/:type/:terms',
                                    'defaults' => array(
                                        'action' => 'categorySearchChildren',
                                    ),
                                ),
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
                    'update-form' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/update-form/:class',
                            'defaults' => array(
                                'action' => 'update-form',
                            ),
                        ),
                    ),
                    'update-record' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/update-record/:class',
                            'defaults' => array(
                                'action' => 'update-record',
                            ),
                        ),
                    ),
                    'update-product' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/update-product',
                            'defaults' => array(
                                'action' => 'update-product',
                            ),
                        ),
                    ),
                    'category-tree-preview' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/category-tree-preview/:siteid',
                            'defaults' => array(
                                'action' => 'categoryTreePreview',
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
