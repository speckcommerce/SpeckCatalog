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
            'speckCatalogRenderForm' => 'Catalog\View\Helper\RenderForm',
            'speckCatalogAdderHelper' => 'Catalog\View\Helper\AdderHelper',
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
            'catalog_generic_service'      => 'Catalog\Service\CatalogService',
            'catalog_model_linker_service' => 'Catalog\Service\ModelLinkerService',
            'catalog_product_service'      => 'Catalog\Service\ProductService',
            'catalog_option_service'       => 'Catalog\Service\OptionService',
            'catalog_image_service'        => 'Catalog\Service\ImageService',
            'catalog_document_service'     => 'Catalog\Service\DocumentService',
            'catalog_category_service'     => 'Catalog\Service\CategoryService',
            'catalog_choice_service'       => 'Catalog\Service\ChoiceService',
            'catalog_product_uom_service'  => 'Catalog\Service\ProductUomService',
            'catalog_uom_service'          => 'Catalog\Service\UomService',
            'catalog_availability_service' => 'Catalog\Service\AvailabilityService',
            'catalog_company_service'      => 'Catalog\Service\CompanyService',
            'catalog_spec_service'         => 'Catalog\Service\SpecService',

            'catalog_product_mapper'      => 'Catalog\Model\Mapper\ProductMapper',
            'catalog_option_mapper'       => 'Catalog\Model\Mapper\OptionMapper',
            'catalog_category_mapper'     => 'Catalog\Model\Mapper\CategoryMapper',
            'catalog_choice_mapper'       => 'Catalog\Model\Mapper\ChoiceMapper',
            'catalog_availability_mapper' => 'Catalog\Model\Mapper\AvailabilityMapper',
            'catalog_product_uom_mapper'  => 'Catalog\Model\Mapper\ProductUomMapper',
            'catalog_image_mapper'        => 'Catalog\Model\Mapper\ImageMapper',
            'catalog_document_mapper'     => 'Catalog\Model\Mapper\DocumentMapper',
            'catalog_company_mapper'      => 'Catalog\Model\Mapper\CompanyMapper',
            'catalog_spec_mapper'         => 'Catalog\Model\Mapper\SpecMapper',
            'catalog_uom_mapper'          => 'Catalog\Model\Mapper\UomMapper',

            'catalog_form_service'      => 'Catalog\Service\FormService',
            'catalog_option_form'       => 'Catalog\Form\Option',
            'catalog_choice_form'       => 'Catalog\Form\Choice',
            'catalog_uom_form'          => 'Catalog\Form\Uom',
            'catalog_company_form'      => 'Catalog\Form\Company',
            'catalog_category_form'     => 'Catalog\Form\Category',
            'catalog_spec_form'         => 'Catalog\Form\Spec',
            'catalog_image_form'        => 'Catalog\Form\Image',
            'catalog_document_form'     => 'Catalog\Form\Document',

            'catalog_product_uom_form_filter' => 'Catalog\Form\FilterProductUom',
            'catalog_availability_form_filter' => 'Catalog\Form\FilterAvailability',
            'catalog_choice_form_filter'      => 'Catalog\Form\FilterChoice',
            'catalog_product_form_filter'     => 'Catalog\Form\FilterProduct',
            'catalog_option_form_filter'      => 'Catalog\Form\FilterOption',
            'catalog_spec_form_filter'        => 'Catalog\Form\FilterSpec',
            'catalog_company_form_filter'     => 'Catalog\Form\FilterCompany',
            'catalog_category_form_filter'    => 'Catalog\Form\FilterCategory',
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
