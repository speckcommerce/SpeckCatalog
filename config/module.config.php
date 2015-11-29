<?php

return [
    'controllers' => [
        'invokables' => [
            'speckcatalog_catalog'  => 'SpeckCatalog\Controller\CatalogController',
            'speckcatalog_product'  => 'SpeckCatalog\Controller\ProductController',
            'speckcatalog_category' => 'SpeckCatalog\Controller\CategoryController',
            'speckcatalog_checkout' => 'SpeckCatalog\Controller\CheckoutController',

            'speckcatalog_manager'  => 'SpeckCatalog\Controller\CatalogManagerController',
            'speckcatalog_manage_category' => 'SpeckCatalog\Controller\ManageCategoryController',
            'speckcatalog_manage_product'  => 'SpeckCatalog\Controller\ManageProductController',
        ],
    ],
    'view_helpers' => [
        'shared' => [
            'speckCatalogForm' => false,
        ],
        'invokables' => [
            'speckCatalogRenderChildren' => 'SpeckCatalog\View\Helper\ChildViewRenderer',
            'speckCatalogForm'           => 'SpeckCatalog\View\Helper\Form',
            'speckCatalog'               => 'SpeckCatalog\View\Helper\Functions',
            'speckCatalogManagerFormRow' => 'SpeckCatalog\Form\View\Helper\CatalogManagerFormRow',
            'speckCatalogUomsToCart'     => 'SpeckCatalog\View\Helper\UomToCart',
        ],
    ],
    'asset_manager' => [
        'resolver_configs' => [
            'paths' => [
                __DIR__ . '/../public',
            ],
        ],
    ],
    'navigation' => [
        'admin' => [
            'products' => [
                'label' => 'Products',
                'route' => 'zfcadmin/catalogmanager/products',
            ],
            'categories' => [
                'label' => 'Product Categories',
                'route' => 'zfcadmin/catalogmanager/categories',
            ],
        ],
    ],
];
