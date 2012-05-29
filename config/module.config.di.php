<?php
return array(

    'di' => array(
        'instance' => array(

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
                    'childOptionLinkerTable' => 'catalog_product_option_linker_tg',
                ),
            ),

            'catalog_option_mapper' => array(
                'parameters' => array(
                    'tableGateway'  => 'catalog_option_tg',
                    'parentProductLinkerTable' => 'catalog_product_option_linker_tg',
                    'parentChoiceLinkerTable' => 'catalog_choice_option_linker_tg'
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
                    'parentOptionLinkerTable' => 'catalog_option_choice_linker_tg',
                    'childOptionLinkerTable'  => 'catalog_choice_option_linker_tg',
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
                    'parentProductLinkerTable'   => 'catalog_product_document_linker_tg',
                ),
            ), 

            'catalog_image_mapper' => array(
                'parameters' => array(
                    'tableGateway'  => 'catalog_media_tg',
                    'parentProductLinkerTable'   => 'catalog_product_image_linker_tg',
                    'parentOptionLinkerTable'    => 'catalog_option_image_linker_tg',
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
                    'table' => 'catalog_product',
                    'adapter' => 'catalog_zend_db_adapter',
                ),
            ),

            'catalog_option_tg' => array(
                'parameters' => array(
                    'table' => 'catalog_option',
                    'adapter' => 'catalog_zend_db_adapter',
                ),
            ),

            'catalog_choice_tg' => array(
                'parameters' => array(
                    'table' => 'catalog_choice',
                    'adapter' => 'catalog_zend_db_adapter',
                ),
            ),

            'catalog_company_tg' => array(
                'parameters' => array(
                    'table' => 'catalog_company',
                    'adapter' => 'catalog_zend_db_adapter',
                ),
            ),

            'catalog_availability_tg' => array(
                'parameters' => array(
                    'table' => 'catalog_availability',
                    'adapter' => 'catalog_zend_db_adapter',
                ),
            ),

            'catalog_product_uom_tg' => array(
                'parameters' => array(
                    'table' => 'catalog_product_uom',
                    'adapter' => 'catalog_zend_db_adapter',
                ),
            ),

            'catalog_spec_tg' => array(
                'parameters' => array(
                    'table' => 'catalog_product_spec',
                    'adapter' => 'catalog_zend_db_adapter',
                ),
            ),

            'catalog_uom_tg' => array(
                'parameters' => array(
                    'table' => 'ansi_uom',
                    'adapter' => 'catalog_zend_db_adapter',
                ),
            ),

            'catalog_media_tg' => array(
                'parameters' => array(
                    'table' => 'catalog_media',
                    'adapter' => 'catalog_zend_db_adapter',
                ),
            ),

            'catalog_product_option_linker_tg' => array(
                'parameters' => array(
                    'table' => 'catalog_product_option_linker',
                    'adapter' => 'catalog_zend_db_adapter',
                ),
            ),

            'catalog_choice_option_linker_tg' => array(
                'parameters' => array(
                    'table' => 'catalog_choice_option_linker',
                    'adapter' => 'catalog_zend_db_adapter',
                ),
            ),

            'catalog_option_choice_linker_tg' => array(
                'parameters' => array(
                    'table' => 'catalog_option_choice_linker',
                    'adapter' => 'catalog_zend_db_adapter',
                ),
            ),

            'catalog_option_image_linker_tg' => array(
                'parameters' => array(
                    'table' => 'catalog_option_image_linker',
                    'adapter' => 'catalog_zend_db_adapter',
                ),
            ),

            'catalog_product_image_linker_tg' => array(
                'parameters' => array(
                    'table' => 'catalog_product_image_linker',
                    'adapter' => 'catalog_zend_db_adapter',
                ),
            ),

            'catalog_product_document_linker_tg' => array(
                'parameters' => array(
                    'table' => 'catalog_product_document_linker',
                    'adapter' => 'catalog_zend_db_adapter',
                ),
            ),
        ),
    ),
);      
