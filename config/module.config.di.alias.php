<?php
//return array();
return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'catalog_install'              => 'Catalog\Service\Installer',

                'catalog_zend_db_adapter'      => 'Zend\Db\Adapter\Adapter',

                'catalog_generic_service'      => 'Catalog\Service\CatalogService',

                'catalog_product_service'      => 'Catalog\Service\ProductService',
                'catalog_option_service'       => 'Catalog\Service\OptionService',
                'catalog_choice_service'       => 'Catalog\Service\ChoiceService',
                'catalog_product_uom_service'  => 'Catalog\Service\ProductUomService',
                'catalog_availability_service' => 'Catalog\Service\AvailabilityService',
                'catalog_company_service'      => 'Catalog\Service\CompanyService',
                'catalog_uom_service'          => 'Catalog\Service\UomService',
                'catalog_spec_service'         => 'Catalog\Service\SpecService',
                'catalog_document_service'     => 'Catalog\Service\DocumentService',
                'catalog_image_service'        => 'Catalog\Service\ImageService',
                'catalog_category_service'     => 'Catalog\Service\CategoryService',
                'catalog_model_linker_service' => 'Catalog\Service\ModelLinkerService',

                'catalog_product_tg'           => 'Zend\Db\TableGateway\TableGateway',
                'catalog_option_tg'            => 'Zend\Db\TableGateway\TableGateway',
                'catalog_choice_tg'            => 'Zend\Db\TableGateway\TableGateway',
                'catalog_product_uom_tg'       => 'Zend\Db\TableGateway\TableGateway',
                'catalog_availability_tg'      => 'Zend\Db\TableGateway\TableGateway',
                'catalog_company_tg'           => 'Zend\Db\TableGateway\TableGateway',
                'catalog_media_tg'             => 'Zend\Db\TableGateway\TableGateway',
                'catalog_spec_tg'              => 'Zend\Db\TableGateway\TableGateway',
                'catalog_uom_tg'               => 'Zend\Db\TableGateway\TableGateway',
                'catalog_category_tg'          => 'Zend\Db\TableGateway\TableGateway',

                'catalog_product_option_linker_tg'   => 'Zend\Db\TableGateway\TableGateway',
                'catalog_choice_option_linker_tg'    => 'Zend\Db\TableGateway\TableGateway',
                'catalog_option_choice_linker_tg'    => 'Zend\Db\TableGateway\TableGateway',
                'catalog_product_image_linker_tg'    => 'Zend\Db\TableGateway\TableGateway',
                'catalog_product_document_linker_tg' => 'Zend\Db\TableGateway\TableGateway',
                

                'catalog_product_mapper'       => 'Catalog\Model\Mapper\ProductMapper',
                'catalog_option_mapper'        => 'Catalog\Model\Mapper\OptionMapper',
                'catalog_choice_mapper'        => 'Catalog\Model\Mapper\ChoiceMapper',
                'catalog_product_uom_mapper'   => 'Catalog\Model\Mapper\ProductUomMapper',
                'catalog_availability_mapper'  => 'Catalog\Model\Mapper\AvailabilityMapper',
                'catalog_company_mapper'       => 'Catalog\Model\Mapper\CompanyMapper',
                'catalog_uom_mapper'           => 'Catalog\Model\Mapper\UomMapper',
                'catalog_spec_mapper'          => 'Catalog\Model\Mapper\SpecMapper',
                'catalog_category_mapper'      => 'Catalog\Model\Mapper\CategoryMapper',
                'catalog_image_mapper'         => 'Catalog\Model\Mapper\ImageMapper',
                'catalog_document_mapper'      => 'Catalog\Model\Mapper\DocumentMapper',
            ),
        ),
    ),
);      
