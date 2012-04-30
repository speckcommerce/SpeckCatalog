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
                    'modelMapper'       => 'catalog_product_mapper',
                    'optionService'     => 'catalog_option_service',
                    'choiceService'     => 'catalog_choice_service',
                    'companyService'    => 'catalog_company_service',
                    'productUomService' => 'catalog_product_uom_service',
                    'documentService'   => 'catalog_document_service',
                    'imageService'      => 'catalog_image_service',
                    'specService'       => 'catalog_spec_service',
                ),
            ),

            'catalog_image_service' => array(
                'parameters' => array(
                    'modelMapper'   => 'catalog_image_mapper',
                ),
            ),

            'catalog_document_service' => array(
                'parameters' => array(
                    'modelMapper'   => 'catalog_document_mapper',
                ),
            ),

            'catalog_option_service' => array(
                'parameters' => array(
                    'modelMapper'    => 'catalog_option_mapper',
                    'choiceService'  => 'catalog_choice_service',
                    'productService' => 'catalog_product_service',
                ),
            ),
            
            'category_category_service' => array(
                'parameters' => array(
                    'modelMapper'    => 'catalog_category_mapper',
                    'productService' => 'catalog_product_service',
                ),
            ),

            'catalog_choice_service' => array(
                'parameters' => array(
                    'modelMapper'    => 'catalog_choice_mapper',
                    'optionService'  => 'catalog_option_service',
                    'productService' => 'catalog_product_service',
                ),
            ),
            
            'catalog_product_uom_service' => array(
                'parameters' => array(
                    'modelMapper'         => 'catalog_product_uom_mapper',
                    'uomService'          => 'catalog_uom_service',
                    'availabilityService' => 'catalog_availability_service',
                ),
            ),
            
            'catalog_uom_service' => array(
                'parameters' => array(
                    'modelMapper' => 'catalog_uom_mapper',
                ),
            ),

            'catalog_availability_service' => array(
                'parameters' => array(
                    'modelMapper'    => 'catalog_availability_mapper',
                    'companyService' => 'catalog_company_service',
                ),
            ),

            'catalog_company_service' => array(
                'parameters' => array(
                    'modelMapper' => 'catalog_company_mapper',
                ),
            ),

            'catalog_spec_service' => array(
                'parameters' => array(
                    'modelMapper' => 'catalog_spec_mapper',
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
                    'tableGateway' => 'catalog_product_tg',
                ),
            ),

            'catalog_option_mapper' => array(
                'parameters' => array(
                    'tableGateway'  => 'catalog_option_tg',
                ),
            ),
            
            'catalog_category_mapper' => array(
                'parameters' => array(
                    'tableGateway'  => 'catalog_category_tg',
                ),
            ),

            'catalog_choice_mapper' => array(
                'parameters' => array(
                    'tableGateway'  => 'catalog_choice_tg',
                ),
            ),

            'catalog_product_uom_mapper' => array(
                'parameters' => array(
                    'tableGateway'  => 'catalog_product_uom_tg',
                ),
            ),

            'catalog_uom_mapper' => array(
                'parameters' => array(
                    'tableGateway'  => 'catalog_uom_tg',
                ),
            ),

            'catalog_availability_mapper' => array(
                'parameters' => array(
                    'tableGateway'  => 'catalog_availability_tg',
                ),
            ),

            'catalog_company_mapper' => array(
                'parameters' => array(
                    'tableGateway'  => 'catalog_company_tg',
                ),
            ),

            'catalog_document_mapper' => array(
                'parameters' => array(
                    'tableGateway'  => 'catalog_media_tg',
                ),
            ), 

            'catalog_image_mapper' => array(
                'parameters' => array(
                    'tableGateway'  => 'catalog_media_tg',
                ),
            ), 

            'catalog_spec_mapper' => array(
                'parameters' => array(
                    'tableGateway'  => 'catalog_spec_tg',
                ),
            ), 
            
            //todo: this.
            'Catalog\Model\Mapper\CatalogMapper' => array(
                'parameters' => array(
                ),
            ),

            /**
             * table gateways 
             */
            'catalog_product_tg' => array(
                'parameters' => array(
                    'tableName' => 'catalog_product',
                    'adapter' => 'catalog_zend_db_adapter',
                ),
            ),

            'catalog_option_tg' => array(
                'parameters' => array(
                    'tableName' => 'catalog_option',
                    'adapter' => 'catalog_zend_db_adapter',
                ),
            ),

            'catalog_choice_tg' => array(
                'parameters' => array(
                    'tableName' => 'catalog_choice',
                    'adapter' => 'catalog_zend_db_adapter',
                ),
            ),

            'catalog_company_tg' => array(
                'parameters' => array(
                    'tableName' => 'catalog_company',
                    'adapter' => 'catalog_zend_db_adapter',
                ),
            ),

            'catalog_availability_tg' => array(
                'parameters' => array(
                    'tableName' => 'catalog_availability',
                    'adapter' => 'catalog_zend_db_adapter',
                ),
            ),

            'catalog_product_uom_tg' => array(
                'parameters' => array(
                    'tableName' => 'catalog_product_uom',
                    'adapter' => 'catalog_zend_db_adapter',
                ),
            ),

            'catalog_uom_tg' => array(
                'parameters' => array(
                    'tableName' => 'catalog_uom',
                    'adapter' => 'catalog_zend_db_adapter',
                ),
            ),
        ),
    ),
);      
