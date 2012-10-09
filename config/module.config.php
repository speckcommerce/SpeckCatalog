<?php

use Catalog\Service\FormServiceAwareInterface;
use Catalog\Service\CatalogServiceAwareInterface;

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
        'invokables' => array(
            'speckCatalogRenderChildren' => 'Catalog\View\Helper\ChildViewRenderer',
            'speckCatalogForm'           => 'Catalog\View\Helper\Form',
            'speckCatalogCart'           => 'Catalog\View\Helper\Cart',
            'speckCatalog'               => 'Catalog\View\Helper\Functions',
        ),
    ),
    'service_manager' => array(
        'shared' => array(
            'cart_item_meta' => false,
        ),
        'invokables' => array(

            'cart_item_meta'                   => 'Catalog\Model\CartItemMeta',

            'catalog_product_service'          => 'Catalog\Service\Product',
            'catalog_category_service'         => 'Catalog\Service\Category',
            'catalog_company_service'          => 'Catalog\Service\Company',
            'catalog_option_service'           => 'Catalog\Service\Option',
            'catalog_choice_service'           => 'Catalog\Service\Choice',
            'catalog_product_uom_service'      => 'Catalog\Service\ProductUom',
            'catalog_uom_service'              => 'Catalog\Service\Uom',
            'catalog_document_service'         => 'Catalog\Service\Document',
            'catalog_availability_service'     => 'Catalog\Service\Availability',
            'catalog_spec_service'             => 'Catalog\Service\Spec',

            'catalog_product_mapper'           => 'Catalog\Mapper\Product',
            'catalog_category_mapper'          => 'Catalog\Mapper\Category',
            'catalog_company_mapper'           => 'Catalog\Mapper\Company',
            'catalog_option_mapper'            => 'Catalog\Mapper\Option',
            'catalog_choice_mapper'            => 'Catalog\Mapper\Choice',
            'catalog_product_uom_mapper'       => 'Catalog\Mapper\ProductUom',
            'catalog_image_mapper'             => 'Catalog\Mapper\Image',
            'catalog_document_mapper'          => 'Catalog\Mapper\Document',
            'catalog_uom_mapper'               => 'Catalog\Mapper\Uom',
            'catalog_availability_mapper'      => 'Catalog\Mapper\Availability',
            'catalog_spec_mapper'              => 'Catalog\Mapper\Spec',

            'catalog_cart_service'             => 'Catalog\Service\CatalogCartService',
            'catalog_form_service'             => 'Catalog\Service\FormService',

            'catalog_option_form'              => 'Catalog\Form\Option',
            'catalog_choice_form'              => 'Catalog\Form\Choice',
            'catalog_uom_form'                 => 'Catalog\Form\Uom',
            'catalog_company_form'             => 'Catalog\Form\Company',
            'catalog_category_form'            => 'Catalog\Form\Category',
            'catalog_spec_form'                => 'Catalog\Form\Spec',
            'catalog_image_form'               => 'Catalog\Form\Image',
            'catalog_document_form'            => 'Catalog\Form\Document',

            'catalog_product_form_filter'      => 'Catalog\Filter\Product',
            'catalog_product_uom_form_filter'  => 'Catalog\Filter\ProductUom',
            'catalog_option_form_filter'       => 'Catalog\Filter\Option',
            'catalog_choice_form_filter'       => 'Catalog\Filter\Choice',
            'catalog_availability_form_filter' => 'Catalog\Filter\Availability',
        ),
    ),
);

$configFiles = array(
    __DIR__ . '/module.config.routes.php',
);

foreach($configFiles as $configFile) {
    $config = Zend\Stdlib\ArrayUtils::merge($config, include $configFile);
}

return $config;
