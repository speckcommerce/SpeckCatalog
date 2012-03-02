<?php
//return array();
return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'catalog_install' => 'Catalog\Service\Installer',
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
            'CatalogManager\Controller\CatalogManagerController' => array(
                'parameters' => array(
                    'catalogService' => 'Catalog\Service\CatalogService',
                    'modelLinkerService' => 'CatalogManager\Service\ModelLinkerService',
                ),
            ),

            'Catalog\Controller\CatalogController' => array(
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

            'CatalogManager\Service\ModelLinkerService' => array(
                'parameters' => array(
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



            // Setup the router and routes
            'Zend\Mvc\Router\RouteStack' => array(
                'parameters' => array(
                    'routes' => array(
                        'productshortcut' => array(
                            'type' => 'Segment',
                            'priority' => -1000,
                            'options' => array(
                                'route' => '/:id',
                                'defaults' => array(
                                    'controller' => 'Catalog\Controller\CatalogController',
                                    'action' => 'productRedirect',
                                ),
                            ),
                        ),
                        'catalog' => array(
                            'type' => 'Literal',
                            'priority' => 1000,
                            'options' => array(
                                'route' => '/catalog',
                                'defaults' => array(
                                    'controller' => 'Catalog\Controller\CatalogController',
                                    'action' => 'index',
                                ),
                            ),
                            'may_terminate' => false,
                            'child_routes' => array(  
                                'product' => array(
                                    'type' => 'Segment',
                                    'options' => array(
                                        'route' => '/product/:id',
                                        'defaults' => array(
                                            'controller' => 'Catalog\Controller\CatalogController',
                                            'action' => 'product',
                                        ),
                                    ),
                                ),
                            ),
                        ), 
                        'catalogmanager' => array(
                            'type' => 'Segment',
                            'priority' => 1000,
                            'options' => array(
                                'route' => '/catalogmanager',
                                'defaults' => array(
                                    'controller' => 'CatalogManager\Controller\CatalogManagerController',
                                    'action' => 'index',
                                ),
                            ),
                            'may_terminate' => true,
                            'child_routes' => array(
                                'new' => array(
                                    'type'    => 'Segment',
                                    'options' => array(
                                        'route'    => '/new/:something[/:constructor]',
                                        'defaults' => array(
                                            'action' => 'new',
                                        ),
                                    ),
                                ),
                                'fetch-partial' => array(
                                    'type'    => 'literal',
                                    'options' => array(
                                        'route'    => '/fetch-partial',
                                        'defaults' => array(
                                            'action' => 'fetchPartial',
                                        ),
                                    ),
                                ),
                                'product' => array(
                                    'type'    => 'Segment',
                                    'options' => array(
                                        'route'    => '/product/:id',
                                        'defaults' => array(
                                            'action' => 'product',
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);      
