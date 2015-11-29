<?php

use SpeckCatalog\Service\FormServiceAwareInterface;
use SpeckCatalog\View\Helper;

return [
    'shared' => [
        //note: this isnt currently working, and as a result, there are the wrong forms almost everywhere in the views :(
        //see github.com/zendframework/zf2 issue #3094
        'speckCatalogRenderForm' => false,
    ],
    'invokables' => [
        'speckCatalogRenderChildren' => 'SpeckCatalog\View\Helper\ChildViewRenderer',
        'speckCatalogRenderForm'     => 'SpeckCatalog\View\Helper\RenderForm',
        'configureBuy'               => 'SpeckCatalog\View\Helper\ConfigureBuy',
        'class'                      => 'SpeckCatalog\View\Helper\CssClass',
    ],
    'factories' => [
        'speckCatalogProduct'   => function ($sm) {
            $sm = $sm->getServiceLocator();
            $helper = new \SpeckCatalog\View\Helper\Product();
            $helper->setProductUomService($sm->get('speckcatalog_product_uom_service'));
            return $helper;
        },
        'speckCatalogAdderHelper' => function ($sm) {
            $sm = $sm->getServiceLocator();
            $options = $sm->get('speckcatalog_module_options');
            $helper = new Helper\AdderHelper;
            $helper->setPartialDir($options->getCatalogManagerPartialDir());
            return $helper;
        },
        'speckCatalogOptionImageUploader' => function ($sm) {
            $imageUploader = $sm->get('imageUploader');
            $element = ['name' => 'file_type', 'attributes' => ['value' => 'optionImage', 'type' => 'hidden']];
            $imageUploader->getForm()->add($element);
            return $imageUploader;
        },
        'speckCatalogManagerSideNav' => function ($sm) {
            $sm = $sm->getServiceLocator();
            $app = $sm->get('application');
            $routeMatch = $app->getMvcEvent()->getRouteMatch();
            $helper = new Helper\CatalogManagerSideNav();
            $helper->setRouteMatch($routeMatch);
            return $helper;
        },
        'speckCatalogProductImageUploader' => function ($sm) {
            $imageUploader = $sm->get('imageUploader');
            $element = ['name' => 'file_type', 'attributes' => ['value' => 'productImage', 'type' => 'hidden']];
            $imageUploader->getForm()->add($element);
            return $imageUploader;
        },
        'speckCatalogProductDocumentUploader' => function ($sm) {
            $uploader = $sm->get('imageUploader');
            $element = ['name' => 'file_type', 'attributes' => ['value' => 'productDocument', 'type' => 'hidden']];
            $uploader->getForm()->add($element);
            return $uploader;
        },
        'speckCatalogCategoryNav' => function ($sm) {
            $sm = $sm->getServiceLocator();
            $helper = new Helper\CategoryNav;
            return $helper->setCategoryService($sm->get('speckcatalog_category_service'));
        },
        'speckCatalogImage' => function ($sm) {
            $sm = $sm->getServiceLocator();
            $settings = $sm->get('speckcatalog_module_options');
            return new Helper\MediaUrl($settings, 'image');
        },
        'speckCatalogFeaturedProducts' => function ($sm) {
            $speckFeaturedProducts = $sm->get('speckFeaturedProducts');
            return $speckFeaturedProducts->setTemplate('/speck-catalog/product/feature-clip');
        },
    ],
    'initializers' => [
        function ($instance, $sm) {
            if ($instance instanceof FormServiceAwareInterface) {
                $sm = $sm->getServiceLocator();
                $formService = $sm->get('speckcatalog_form_service');
                $instance->setFormService($formService);
            }
        },
    ],
];
