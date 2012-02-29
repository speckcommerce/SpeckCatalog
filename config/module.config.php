<?php
//return array();
return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'catalog_install' => 'Catalog\Service\Installer',
                'catalog' => 'Catalog\Controller\IndexController',
                'catalogmanager' => 'CatalogManager\Controller\IndexController',
                'masterzdb' => 'Zend\Db\Adapter\DiPdoMysql',
                'catalog_read_db'         => 'masterzdb',
                'catalog_write_db'        => 'masterzdb',
            ),
            'masterzdb' => array(
                'parameters' => array(
                    'pdo'    => 'masterdb',
                    'config' => array(),
                ),
            ),   
            'CatalogManager\Controller\IndexController' => array(
                'parameters' => array(
                    'catalogService' => 'Catalog\Service\CatalogService',
                ),
            ),

            'Catalog\Controller\IndexController' => array(
                'parameters' => array(
                    'catalogService' => 'Catalog\Service\CatalogService',
                ),
            ),


            /**
             * Services 
             */
            'Catalog\Service\CatalogService' => array(
                'parameters' => array(
                    'productService' => 'Catalog\Service\ProductService',
                    'mapper' => 'Catalog\Model\Mapper\MYSQL_CatalogMapper',
                ),
            ),

            'Catalog\Service\ProductService' => array(
                'parameters' => array(
                    'modelMapper' => 'Catalog\Model\Mapper\ProductMapper',
                    'optionService' => 'Catalog\Service\OptionService',
                    'choiceService' => 'Catalog\Service\ChoiceService',
                    'companyService' => 'Catalog\Service\CompanyService',
                    'productUomService' => 'Catalog\Service\ProductUomService',

                ),
            ),

            'Catalog\Service\OptionService' => array(
                'parameters' => array(
                    'modelMapper' => 'Catalog\Model\Mapper\OptionMapper',
                    'choiceService' => 'Catalog\Service\ChoiceService',
                ),
            ),

            'Catalog\Service\ChoiceService' => array(
                'parameters' => array(
                    'modelMapper' => 'Catalog\Model\Mapper\ChoiceMapper',
                    'optionService' => 'Catalog\Service\OptionService',
                    'productService' => 'Catalog\Service\ProductService',
                ),
            ),
            
            'Catalog\Service\ProductUomService' => array(
                'parameters' => array(
                    'modelMapper' => 'Catalog\Model\Mapper\ProductUomMapper',
                    'uomService' => 'Catalog\Service\UomService',
                    'availabilityService' => 'Catalog\Service\AvailabilityService',
                ),
            ),
            
            'Catalog\Service\UomService' => array(
                'parameters' => array(
                    'modelMapper' => 'Catalog\Model\Mapper\UomMapper',
                ),
            ),

            'Catalog\Service\AvailabilityService' => array(
                'parameters' => array(
                    'modelMapper' => 'Catalog\Model\Mapper\AvailabilityMapper',
                    'companyService' => 'Catalog\Service\CompanyService',
                ),
            ),

            'Catalog\Service\CompanyService' => array(
                'parameters' => array(
                    'modelMapper' => 'Catalog\Model\Mapper\CompanyMapper',
                ),
            ),

            'Catalog\Service\Installer' => array(
                'parameters' => array(
                    'catalogService' => 'Catalog\Service\CatalogService',
                ),
            ),   



            /**
             * Mappers 
             */
            'Catalog\Model\Mapper\ProductMapper' => array(
                'parameters' => array(
                    'readAdapter' => 'catalog_read_db',
                    'writeAdapter' => 'catalog_write_db',
                ),
            ),

            'Catalog\Model\Mapper\OptionMapper' => array(
                'parameters' => array(
                    'readAdapter' => 'catalog_read_db',
                    'writeAdapter' => 'catalog_write_db',
                ),
            ),

            'Catalog\Model\Mapper\ChoiceMapper' => array(
                'parameters' => array(
                    'readAdapter' => 'catalog_read_db',
                    'writeAdapter' => 'catalog_write_db',
                ),
            ),

            'Catalog\Model\Mapper\ProductUomMapper' => array(
                'parameters' => array(
                    'readAdapter' => 'catalog_read_db',
                    'writeAdapter' => 'catalog_write_db',
                ),
            ),

            'Catalog\Model\Mapper\UomMapper' => array(
                'parameters' => array(
                    'readAdapter' => 'catalog_read_db',
                    'writeAdapter' => 'catalog_write_db',
                ),
            ),

            'Catalog\Model\Mapper\AvailabilityMapper' => array(
                'parameters' => array(
                    'readAdapter' => 'catalog_read_db',
                    'writeAdapter' => 'catalog_write_db',
                ),
            ),

            'Catalog\Model\Mapper\CompanyMapper' => array(
                'parameters' => array(
                    'readAdapter' => 'catalog_read_db',
                    'writeAdapter' => 'catalog_write_db',
                ),
            ),

            'Catalog\Model\Mapper\MYSQL_CatalogMapper' => array(
                'parameters' => array(
                    'readAdapter' => 'catalog_read_db',
                    'writeAdapter' => 'catalog_write_db',
                ),
            ),




            'Zend\View\Resolver\TemplatePathStack' => array(
                'parameters' => array(
                    'paths'  => array(
                        'catalog' => __DIR__ . '/../view',
                    ),
                ),
            ),
        ),
    ),
);      
