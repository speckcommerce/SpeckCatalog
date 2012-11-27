<?php

$config = array(
    'controllers' => array(
        'invokables' => array(
            'catalog'         => 'Catalog\Controller\CatalogController',
            'product'         => 'Catalog\Controller\ProductController',
            'category'        => 'Catalog\Controller\CategoryController',
            'catalogcart'     => 'Catalog\Controller\CartController',
            'checkout'        => 'Catalog\Controller\CheckoutController',

            'catalogmanager'  => 'Catalog\Controller\CatalogManagerController',
            'manage-category' => 'Catalog\Controller\ManageCategoryController',
            'manage-product'  => 'Catalog\Controller\ManageProductController',
        ),
    ),
    'view_helpers' => array(
        'shared' => array(
            'speckCatalogForm' => false,
        ),
        'invokables' => array(
            'speckCatalogRenderChildren' => 'Catalog\View\Helper\ChildViewRenderer',
            'speckCatalogForm'           => 'Catalog\View\Helper\Form',
            'speckCatalogCart'           => 'Catalog\View\Helper\Cart',
            'speckCatalog'               => 'Catalog\View\Helper\Functions',
            'speckCatalogManagerFormRow' => 'Catalog\Form\View\Helper\CatalogManagerFormRow',
            'speckCatalogUomsToCart'     => 'Catalog\View\Helper\UomToCart',
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
            'mynavigation' => array(
                'label' => 'Catalog Manager',
                'route' => 'catalogmanager',
            ),
        ),
    ),
);
return $config;
