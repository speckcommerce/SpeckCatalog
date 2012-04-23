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
                'product_service' => 'Catalog\Service\ProductService', //hacky -- fix me!
                'option_service' => 'Catalog\Service\OptionService', //also hacky -- fix me next!
            ),
            'masterzdb' => array(
                'parameters' => array(
                    'pdo'    => 'masterdb',
                    'config' => array(),
                ),
            ),
            
            'CatalogManager\Controller\CatalogManagerController' => array(
                'parameters' => array(
                    'catalogService'     => 'Catalog\Service\CatalogService',
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
                    'productService'      => 'product_service',
                    'productUomService'   => 'Catalog\Service\ProductUomService',
                    'availabilityService' => 'Catalog\Service\AvailabilityService',
                    'optionService'       => 'option_service',
                    'choiceService'       => 'Catalog\Service\ChoiceService',
                    'categoryService'     => 'Catalog\Service\CategoryService',
                    'specService'         => 'Catalog\Service\SpecService',
                    'documentService'     => 'Catalog\Service\DocumentService',
                    'imageService'        => 'Catalog\Service\ImageService',
                ),
            ),

            'product_service' => array(
                'parameters' => array(
                    'modelMapper'       => 'Catalog\Model\Mapper\ProductMapper',
                    'optionService'     => 'option_service',
                    'choiceService'     => 'Catalog\Service\ChoiceService',
                    'companyService'    => 'Catalog\Service\CompanyService',
                    'productUomService' => 'Catalog\Service\ProductUomService',
                    'documentService'   => 'Catalog\Service\DocumentService',
                    'imageService'      => 'Catalog\Service\ImageService',
                    'specService'       => 'Catalog\Service\SpecService',
                    'choiceService'     => 'Catalog\Service\ChoiceService',
                ),
            ),
            
            'CatalogManager\Service\ModelLinkerService' => array(
                'parameters' => array(
                    'productService'      => 'product_service',
                    'optionService'       => 'option_service',
                    'choiceService'       => 'Catalog\Service\ChoiceService',
                    'productUomService'   => 'Catalog\Service\ProductUomService',
                    'availabilityService' => 'Catalog\Service\AvailabilityService',
                    'categoryService'     => 'Catalog\Service\CategoryService',
                    'imageService'        => 'Catalog\Service\ImageService',
                    'documentService'     => 'Catalog\Service\DocumentService',
                    'specService'         => 'Catalog\Service\SpecService',
                ),
            ),   

            'Catalog\Service\ImageService' => array(
                'parameters' => array(
                    'modelMapper'   => 'Catalog\Model\Mapper\ImageMapper',
                ),
            ),

            'Catalog\Service\DocumentService' => array(
                'parameters' => array(
                    'modelMapper'   => 'Catalog\Model\Mapper\DocumentMapper',
                ),
            ),

            'option_service' => array(
                'parameters' => array(
                    'modelMapper'    => 'Catalog\Model\Mapper\OptionMapper',
                    'choiceService'  => 'Catalog\Service\ChoiceService',
                    'productService' => 'product_service',
                ),
            ),
            
            'Catalog\Service\CategoryService' => array(
                'parameters' => array(
                    'productService' => 'product_service',
                    'modelMapper'    => 'Catalog\Model\Mapper\CategoryMapper',
                ),
            ),

            'Catalog\Service\ChoiceService' => array(
                'parameters' => array(
                    'modelMapper'    => 'Catalog\Model\Mapper\ChoiceMapper',
                    'optionService'  => 'option_service',
                    'productService' => 'product_service',
                ),
            ),
            
            'Catalog\Service\ProductUomService' => array(
                'parameters' => array(
                    'modelMapper'         => 'Catalog\Model\Mapper\ProductUomMapper',
                    'uomService'          => 'Catalog\Service\UomService',
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
                    'modelMapper'    => 'Catalog\Model\Mapper\AvailabilityMapper',
                    'companyService' => 'Catalog\Service\CompanyService',
                ),
            ),

            'Catalog\Service\CompanyService' => array(
                'parameters' => array(
                    'modelMapper' => 'Catalog\Model\Mapper\CompanyMapper',
                ),
            ),

            'Catalog\Service\SpecService' => array(
                'parameters' => array(
                    'modelMapper' => 'Catalog\Model\Mapper\SpecMapper',
                ),
            ),

            'Catalog\Service\Installer' => array(
                'parameters' => array(
                    'mapper' => 'Catalog\Model\Mapper\CatalogMapper',
                ),
            ),


            /**
             * Mappers 
             */
            'Catalog\Model\Mapper\ProductMapper' => array(
                'parameters' => array(
                    'readAdapter'  => 'catalog_read_db',
                    'writeAdapter' => 'catalog_write_db',
                ),
            ),

            'Catalog\Model\Mapper\OptionMapper' => array(
                'parameters' => array(
                    'readAdapter'  => 'catalog_read_db',
                    'writeAdapter' => 'catalog_write_db',
                ),
            ),
            
            'Catalog\Model\Mapper\CategoryMapper' => array(
                'parameters' => array(
                    'readAdapter'  => 'catalog_read_db',
                    'writeAdapter' => 'catalog_write_db',
                ),
            ),

            'Catalog\Model\Mapper\ChoiceMapper' => array(
                'parameters' => array(
                    'readAdapter'  => 'catalog_read_db',
                    'writeAdapter' => 'catalog_write_db',
                ),
            ),

            'Catalog\Model\Mapper\ProductUomMapper' => array(
                'parameters' => array(
                    'readAdapter'  => 'catalog_read_db',
                    'writeAdapter' => 'catalog_write_db',
                ),
            ),

            'Catalog\Model\Mapper\UomMapper' => array(
                'parameters' => array(
                    'readAdapter'  => 'catalog_read_db',
                    'writeAdapter' => 'catalog_write_db',
                ),
            ),

            'Catalog\Model\Mapper\AvailabilityMapper' => array(
                'parameters' => array(
                    'readAdapter'  => 'catalog_read_db',
                    'writeAdapter' => 'catalog_write_db',
                ),
            ),

            'Catalog\Model\Mapper\CompanyMapper' => array(
                'parameters' => array(
                    'readAdapter'  => 'catalog_read_db',
                    'writeAdapter' => 'catalog_write_db',
                ),
            ),

            'Catalog\Model\Mapper\ImageMapper' => array(
                'parameters' => array(
                    'readAdapter'  => 'catalog_read_db',
                    'writeAdapter' => 'catalog_write_db',
                ),
            ), 

            'Catalog\Model\Mapper\DocumentMapper' => array(
                'parameters' => array(
                    'readAdapter'  => 'catalog_read_db',
                    'writeAdapter' => 'catalog_write_db',
                ),
            ), 

            'Catalog\Model\Mapper\ImageMapper' => array(
                'parameters' => array(
                    'readAdapter'  => 'catalog_read_db',
                    'writeAdapter' => 'catalog_write_db',
                ),
            ), 

            'Catalog\Model\Mapper\SpecMapper' => array(
                'parameters' => array(
                    'readAdapter'  => 'catalog_read_db',
                    'writeAdapter' => 'catalog_write_db',
                ),
            ), 

            'Catalog\Model\Mapper\CatalogMapper' => array(
                'parameters' => array(
                    'readAdapter'  => 'catalog_read_db',
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
                                        'route'    => '/new/:class[/:constructor]',
                                        'defaults' => array(
                                            'action' => 'new',
                                        ),
                                    ),
                                ),
                                'sort' => array(
                                    'type'    => 'Segment',
                                    'options' => array(
                                        'route'    => '/sort/:type/:parent',
                                        'defaults' => array(
                                            'action' => 'sort',
                                        ),
                                    ),
                                ),
                                'remove' => array(
                                    'type'    => 'Segment',
                                    'options' => array(
                                        'route'    => '/remove/:type/:linkerId',
                                        'defaults' => array(
                                            'action' => 'remove',
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
                                'products' => array(
                                    'type'    => 'Segment',
                                    'options' => array(
                                        'route'    => '/products[/:page]',
                                        'defaults' => array(
                                            'action' => 'products',
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
                                'categories' => array(
                                    'type'    => 'Segment',
                                    'options' => array(
                                        'route'    => '/categories[/:page]',
                                        'defaults' => array(
                                            'action' => 'categories',
                                        ),
                                    ),
                                ),
                                'search-class' => array(
                                    'type' => 'Literal',
                                    'options' => array(
                                        'route' => '/search-class',
                                        'defaults' => array(
                                            'action' => 'search-class',
                                        ),
                                    ),
                                ),
                                'update-record' => array(
                                    'type' => 'Segment',
                                    'options' => array(
                                        'route' => '/update-record/:class/:id',
                                        'defaults' => array(
                                            'action' => 'update-record',
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
