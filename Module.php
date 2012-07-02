<?php

namespace SpeckCatalog;

use Zend\ModuleManager\ModuleManager,
    Zend\Navigation,
    Application\Extra\Page,
    Service\Installer,
    Catalog\Model\Mapper;

class Module
{
    protected $view;
    protected $viewListener;

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                    'CatalogManager' => __DIR__ . '/src/CatalogManager',
                    'Catalog' => __DIR__ . '/src/Catalog',
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap($e)
    {
        $app          = $e->getParam('application');
        $locator      = $app->getServiceManager();
        $renderer     = $locator->get('Zend\View\Renderer\PhpRenderer');
        $renderer->plugin('url')->setRouter($locator->get('Router'));
        $renderer->plugin('headScript')->appendFile('/assets/speck-catalog/js/speck-catalog-manager.js');
        $renderer->plugin('headLink')->appendStylesheet('/assets/speck-catalog/css/speck-catalog.css');
    }

    public function getServiceConfiguration()
    {
        return array(
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

                'catalogmanager_generic_service' => 'CatalogManager\Service\CatalogManagerService',
                'catalogmanager_form_service'  => 'CatalogManager\Service\FormService',
                'catalogmanager_product_service' => 'CatalogManager\Service\ProductService',
                'catalogmanager_option_service' => 'CatalogManager\Service\OptionService',

                'catalogmanager_product_form' => 'CatalogManager\Form\Product',
                'catalogmanager_option_form' => 'CatalogManager\Form\Option',
            ),
            'factories' => array(
                'catalog_db' => function ($sm) {
                    return $sm->get('Zend\Db\Adapter\Adapter');
                },
                //model mappers
                'catalog_product_mapper' => function ($sm) {
                    $tg = new \Catalog\Model\Mapper\TableGateway('catalog_product', $sm->get('catalog_db'));
                    return new \Catalog\Model\Mapper\ProductMapper($tg);
                },
                'catalog_option_mapper' => function ($sm) {
                    $tg = new Mapper\TableGateway('catalog_option', $sm->get('catalog_db'));
                    return new Mapper\OptionMapper($tg);
                },
                'catalog_category_mapper' => function ($sm) {
                    $tg = new Mapper\TableGateway('catalog_category', $sm->get('catalog_db'));
                    return new Mapper\categoryMapper($tg);
                },
                'catalog_choice_mapper' => function ($sm) {
                    $tg = new Mapper\TableGateway('catalog_choice', $sm->get('catalog_db'));
                    return new Mapper\ChoiceMapper($tg);
                },
                'catalog_availability_mapper' => function ($sm) {
                    $tg = new Mapper\TableGateway('catalog_availability', $sm->get('catalog_db'));
                    return new Mapper\AvailabilityMapper($tg);
                },
                'catalog_product_uom_mapper' => function ($sm) {
                    $tg = new Mapper\TableGateway('catalog_product_uom', $sm->get('catalog_db'));
                    return new Mapper\ProductUomMapper($tg);
                },
                'catalog_image_mapper' => function ($sm) {
                    $tg = new Mapper\TableGateway('catalog_media', $sm->get('catalog_db'));
                    return new Mapper\ImageMapper($tg);
                },
                'catalog_document_mapper' => function ($sm) {
                    $tg = new Mapper\TableGateway('catalog_media', $sm->get('catalog_db'));
                    return new Mapper\DocumentMapper($tg);
                },
                'catalog_company_mapper' => function ($sm) {
                    $tg = new Mapper\TableGateway('catalog_company', $sm->get('catalog_db'));
                    return new Mapper\CompanyMapper($tg);
                },
                'catalog_spec_mapper' => function ($sm) {
                    $tg = new Mapper\TableGateway('catalog_product_spec', $sm->get('catalog_db'));
                    return new Mapper\SpecMapper($tg);
                },
                'catalog_uom_mapper' => function ($sm) {
                    $tg = new Mapper\TableGateway('ansi_uom', $sm->get('catalog_db'));
                    return new Mapper\UomMapper($tg);
                },
                //linker table gateways
                'catalog_option_choice_linker_tg' => function ($sm) {
                    return new Mapper\TableGateway('catalog_option_choice_linker', $sm->get('catalog_db'));
                },
                'catalog_choice_option_linker_tg' => function ($sm) {
                    return new Mapper\TableGateway('catalog_choice_option_linker', $sm->get('catalog_db'));
                },
                'catalog_product_option_linker_tg' => function ($sm) {
                    return new Mapper\TableGateway('catalog_product_option_linker', $sm->get('catalog_db'));
                },
                'catalog_product_image_linker_tg' => function ($sm) {
                    return new Mapper\TableGateway('catalog_product_image_linker', $sm->get('catalog_db'));
                },
                'catalog_option_image_linker_tg' => function ($sm) {
                    return new Mapper\TableGateway('catalog_option_image_linker', $sm->get('catalog_db'));
                },
                'catalog_product_document_linker_tg' => function ($sm) {
                    return new Mapper\TableGateway('catalog_product_document_linker', $sm->get('catalog_db'));
                },








            ),
        );
    }

}
