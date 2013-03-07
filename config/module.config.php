<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'speckcatalog_catalog'  => 'SpeckCatalog\Controller\CatalogController',
            'speckcatalog_product'  => 'SpeckCatalog\Controller\ProductController',
            'speckcatalog_category' => 'SpeckCatalog\Controller\CategoryController',
            'speckcatalog_cart'     => 'SpeckCatalog\Controller\CartController',
            'speckcatalog_checkout' => 'SpeckCatalog\Controller\CheckoutController',

            'speckcatalog_manager'  => 'SpeckCatalog\Controller\CatalogManagerController',
            'speckcatalog_manage_category' => 'SpeckCatalog\Controller\ManageCategoryController',
            'speckcatalog_manage_product'  => 'SpeckCatalog\Controller\ManageProductController',
        ),
    ),
    'view_helpers' => array(
        'shared' => array(
            'speckCatalogForm' => false,
        ),
        'invokables' => array(
            'speckCatalogRenderChildren' => 'SpeckCatalog\View\Helper\ChildViewRenderer',
            'speckCatalogForm'           => 'SpeckCatalog\View\Helper\Form',
            'speckCatalogCart'           => 'SpeckCatalog\View\Helper\Cart',
            'speckCatalog'               => 'SpeckCatalog\View\Helper\Functions',
            'speckCatalogManagerFormRow' => 'SpeckCatalog\Form\View\Helper\CatalogManagerFormRow',
            'speckCatalogUomsToCart'     => 'SpeckCatalog\View\Helper\UomToCart',
        ),
    ),
    'asset_manager' => array(
        'resolver_configs' => array(
            'paths' => array(
                __DIR__ . '/../public',
            ),
        ),
    ),
    'navigation' => array(
        'admin' => array(
            'catalogmanager' => array(
                'label' => 'Catalog',
                'route' => 'zfcadmin/catalogmanager',
            ),
        ),
    ),
);
