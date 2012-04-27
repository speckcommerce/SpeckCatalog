<?php
return array(
    'di' => array(
        'instance' => array(

            'CatalogManager\Controller\CatalogManagerController' => array(
                'parameters' => array(
                    'catalogService'     => 'catalog_generic_service',
                ),
            ),
            'Catalog\Controller\CatalogController' => array(
                'parameters' => array(
                    'catalogService' => 'catalog_generic_service',
                ),
            ),  

            /**
             * Services 
             */
            'catalog_generic_service' => array(
                'parameters' => array(
                    'productService'      => 'catalog_product_service',
                    'productUomService'   => 'catalog_product_uom_service',
                    'availabilityService' => 'catalog_availability_service',
                    'optionService'       => 'catalog_option_service',
                    'choiceService'       => 'catalog_choice_service',
                    'categoryService'     => 'catalog_category_service',
                    'specService'         => 'catalog_spec_service',
                    'documentService'     => 'catalog_document_service',
                    'imageService'        => 'catalog_image_service',
                ),
            ),

            'catalog_product_service' => array(
                'parameters' => array(
                    'tableGateway'      => 'catalog_product_tg',
                    'optionService'     => 'catalog_option_service',
                    'choiceService'     => 'catalog_chocie_service',
                    'companyService'    => 'catalog_company_service',
                    'productUomService' => 'catalog_product_uom_service',
                    'documentService'   => 'catalog_document_service',
                    'imageService'      => 'catalog_image_service',
                    'specService'       => 'catalog_spec_service',
                ),
            ),

            'catalog_image_service' => array(
                'parameters' => array(
                    'tableGateway'   => 'catalog_image_tg',
                ),
            ),

            'catalog_document_service' => array(
                'parameters' => array(
                    'tableGateway'   => 'catalog_document_tg',
                ),
            ),

            'catalog_option_service' => array(
                'parameters' => array(
                    'tableGateway'   => 'catalog_option_tg',
                    'choiceService'  => 'catalog_choice_service',
                    'productService' => 'catalog_product_service',
                ),
            ),
            
            'category_category_service' => array(
                'parameters' => array(
                    'tableGateway'    => 'catalog_category_tg',
                    'productService' => 'catalog_product_service',
                ),
            ),

            'catalog_choice_service' => array(
                'parameters' => array(
                    'tableGateway'    => 'catalog_choice_tg',
                    'optionService'  => 'catalog_option_service',
                    'productService' => 'catalog_product_service',
                ),
            ),
            
            'catalog_product_uom_service' => array(
                'parameters' => array(
                    'tableGateway'         => 'catalog_product_uom_tg',
                    'uomService'          => 'catalog_uom_service',
                    'availabilityService' => 'catalog_availability_service',
                ),
            ),
            
            'catalog_uom_service' => array(
                'parameters' => array(
                    'tableGateway' => 'catalog_uom_tg',
                ),
            ),

            'catalog_availability_service' => array(
                'parameters' => array(
                    'tableGateway'    => 'catalog_availability_tg',
                    'companyService' => 'catalog_company_service',
                ),
            ),

            'catalog_company_service' => array(
                'parameters' => array(
                    'tableGateway' => 'catalog_company_tg',
                ),
            ),

            'catalog_spec_service' => array(
                'parameters' => array(
                    'tableGateway' => 'catalog_spec_tg',
                ),
            ),


            //todo:  this.
            'Catalog\Service\Installer' => array(
                'parameters' => array(
                    'mapper' => 'Catalog\Model\Mapper\CatalogMapper',
                ),
            ),

            /**
             * Mappers 
             */
            'catalog_product_mapper' => array(
                'parameters' => array(
                    'tableName' => 'catalog_product',
                    'adapter'   => 'catalog_zend_db_adapter',
                ),
            ),

            'Catalog\Model\Mapper\OptionMapper' => array(
                'parameters' => array(
                    'tableName'  => 'catalog_option',
                    'adapter' => 'catalog_zend_db_adapter',
                ),
            ),

            'Catalog\Model\Mapper\OptionMapper' => array(
                'parameters' => array(
                    'tableName'  => 'catalog_option',
                    'adapter' => 'catalog_zend_db_adapter',
                ),
            ),
            
            'Catalog\Model\Mapper\CategoryMapper' => array(
                'parameters' => array(
                    'tablename'  => 'catalog_category',
                    'adapter' => 'catalog_zend_db_adapter',
                ),
            ),

            'Catalog\Model\Mapper\ChoiceMapper' => array(
                'parameters' => array(
                    'tablename'  => 'catalog_choice',
                    'adapter' => 'catalog_zend_db_adapter',
                ),
            ),

            'Catalog\Model\Mapper\ProductUomMapper' => array(
                'parameters' => array(
                    'tablename'  => 'catalog_product_uom',
                    'adapter' => 'catalog_zend_db_adapter',
                ),
            ),

            'Catalog\Model\Mapper\UomMapper' => array(
                'parameters' => array(
                    'tablename'  => 'catalog_uom',
                    'adapter' => 'catalog_zend_db_adapter',
                ),
            ),

            'Catalog\Model\Mapper\AvailabilityMapper' => array(
                'parameters' => array(
                    'tablename'  => 'catalog_availability',
                    'adapter' => 'catalog_zend_db_adapter',
                ),
            ),

            'Catalog\Model\Mapper\CompanyMapper' => array(
                'parameters' => array(
                    'tablename'  => 'catalog_company',
                    'adapter' => 'catalog_zend_db_adapter',
                ),
            ),

            'Catalog\Model\Mapper\DocumentMapper' => array(
                'parameters' => array(
                    'tablename'  => 'catalog_media',
                    'adapter' => 'catalog_zend_db_adapter',
                ),
            ), 

            'Catalog\Model\Mapper\ImageMapper' => array(
                'parameters' => array(
                    'tablename'  => 'catalog_media',
                    'adapter' => 'catalog_zend_db_adapter',
                ),
            ), 

            'Catalog\Model\Mapper\SpecMapper' => array(
                'parameters' => array(
                    'tablename'  => 'catalog_spec',
                    'adapter' => 'catalog_zend_db_adapter',
                ),
            ), 

            //todo: this.
            'Catalog\Model\Mapper\CatalogMapper' => array(
                'parameters' => array(
                    'tablename'  => '',
                    'adapter' => 'catalog_zend_db_adapter',
                ),
            ),
        ),
    ),
);      
