<?php
return array(
    'invokables' => array(
        'speckCatalogRenderChildren' => 'Catalog\View\Helper\ChildViewRenderer',
        'speckCatalogRenderForm'     => 'Catalog\View\Helper\RenderForm',
        'speckCatalogCart'           => 'Catalog\View\Helper\Cart',
        'speckCatalogAdderHelper'    => 'Catalog\View\Helper\AdderHelper',
    ),
    'factories' => array(
        'speckCatalogOptionImageUploader'  => function ($sm) {
            $imageUploader = $sm->get('imageUploader');
            $element = array('name' => 'file_type', 'attributes' => array('value' => 'optionImage', 'type' => 'hidden'));
            $imageUploader->getForm()->add($element);
            return $imageUploader;
        },
        'speckCatalogManagerSideNav' => function ($sm) {
            $sm = $sm->getServiceLocator();
            $app = $sm->get('application');
            $routeMatch = $app->getMvcEvent()->getRouteMatch();
            $helper = new \Catalog\View\Helper\CatalogManagerSideNav();
            $helper->setRouteMatch($routeMatch);
            return $helper;
        },
        'speckCatalogProductImageUploader'  => function ($sm) {
            $imageUploader = $sm->get('imageUploader');
            $element = array('name' => 'file_type', 'attributes' => array('value' => 'productImage', 'type' => 'hidden'));
            $imageUploader->getForm()->add($element);
            return $imageUploader;
        },
        'speckCatalogProductDocumentUploader' => function ($sm) {
            $uploader = $sm->get('imageUploader');
            $element = array('name' => 'file_type', 'attributes' => array('value' => 'productDocument', 'type' => 'hidden'));
            $uploader->getForm()->add($element);
            return $uploader;
        },
        'speckCatalogCategoryNav'    => function ($sm) {
            $sm = $sm->getServiceLocator();
            $helper = new \Catalog\View\Helper\CategoryNav;
            return $helper->setCategoryService($sm->get('catalog_category_service'));
        },
        'speckCatalogImage' => function ($sm) {
            $sm = $sm->getServiceLocator();
            $settings = $sm->get('catalog_module_options');
            return new \Catalog\View\Helper\MediaUrl($settings, 'image');
        },
        'speckCatalogFeaturedProducts' => function ($sm) {
            $speckFeaturedProducts = $sm->get('speckFeaturedProducts');
            return $speckFeaturedProducts->setTemplate('/catalog/product/feature-clip');
        },
    ),
    'initializers' => array(
        function($instance, $sm){
            if($instance instanceof \Catalog\Service\FormServiceAwareInterface){
                $sm = $sm->getServiceLocator();
                $formService = $sm->get('catalog_form_service');
                $instance->setFormService($formService);
            }
        },
    ),
);
