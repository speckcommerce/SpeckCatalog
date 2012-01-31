<?php
return array(
    'layout' => 'layouts/catalog-manage.phtml',
    'di' => array(
        'instance' => array(
            'alias' => array(
                'catalog'                 => 'SpeckCatalog\Controller\IndexController',
                'catalogmanager'          => 'SpeckCatalogManager\Controller\IndexController',
                'catalog_read_db'         => 'masterzdb',
                'catalog_write_db'        => 'masterzdb',
            ),
            'catalog' => array(
                'parameters' => array(
                    'productService' => 'SpeckCatalog\Service\ProductService',
                ),
            ),
            'catalogmanager' => array(
                'parameters' => array(
                    'userService'         => 'speckcatalog_user_service',
                    'productService'      => 'SpeckCatalog\Service\ProductService',
                    'productUomService'   => 'SpeckCatalog\Service\ProductUomService',
                    'optionService'       => 'SpeckCatalog\Service\OptionService',
                    'choiceService'       => 'SpeckCatalog\Service\ChoiceService',
                    'availabilityService' => 'SpeckCatalog\Service\AvailabilityService',
                ),
            ),
            'Zend\View\PhpRenderer' => array(
                'parameters' => array(
                    'options'  => array(
                        'script_paths' => array(
                            'SwmBase' => __DIR__ . '/../views',
                        ),
                    ),
                ),
            ), 
            'orm_driver_chain' => array(
                'parameters' => array(
                    'drivers' => array(
                        'speckcatalog_annotationdriver' => array(
                            'class'           => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                            'namespace'       => 'Catalog\Entity',
                            'paths'           => array(__DIR__ . '/../src/Catalog/Entity'),
                        ),
                    ),
                )
            ),
            'SpeckCatalog\Service\OptionService' => array(
                'parameters' => array(
                    'modelMapper'   => 'SpeckCatalog\Model\Mapper\OptionMapper',
                    'choiceService' => 'SpeckCatalog\Service\ChoiceService',
                ),
            ),          
            'SpeckCatalog\Service\ChoiceService' => array(
                'parameters' => array(
                    'modelMapper'    => 'SpeckCatalog\Model\Mapper\ChoiceMapper',
                    'productService' => 'SpeckCatalog\Service\ProductService',
                    'optionService'  => 'SpeckCatalog\Service\OptionService',
                ),
            ),
            'SpeckCatalog\Service\ProductService' => array(
                'parameters' => array(
                    'modelMapper'       => 'SpeckCatalog\Model\Mapper\ProductMapper',
                    'optionService'     => 'SpeckCatalog\Service\OptionService',
                    'productUomService' => 'SpeckCatalog\Service\ProductUomService',
                    'companyService'    => 'SpeckCatalog\Service\CompanyService',
                ),
            ),
            'SpeckCatalog\Service\AvailabilityService' => array(
                'parameters' => array(
                    'modelMapper'    => 'SpeckCatalog\Model\Mapper\AvailabilityMapper',
                    'companyService' => 'SpeckCatalog\Service\CompanyService',
                ),
            ),              
             'SpeckCatalog\Service\ProductUomService' => array(
                'parameters' => array(
                    'modelMapper'         => 'SpeckCatalog\Model\Mapper\ProductUomMapper',
                    'availabilityService' => 'SpeckCatalog\Service\AvailabilityService',
                ),
            ),              
            'SpeckCatalog\Service\CompanyService' => array(
                'parameters' => array(
                    'modelMapper' => 'SpeckCatalog\Model\Mapper\CompanyMapper',
                ),
            ),
            'SpeckCatalog\Model\Mapper\ChoiceMapper' => array(
                'parameters' => array(
                    'readAdapter'  => 'catalog_read_db',
                    'writeAdapter' => 'catalog_write_db',
                ),
            ),            
            'SpeckCatalog\Model\Mapper\OptionMapper' => array(
                'parameters' => array(
                    'readAdapter'  => 'catalog_read_db',
                    'writeAdapter' => 'catalog_write_db',
                ),
            ),
            'SpeckCatalog\Model\Mapper\ProductUomMapper' => array(
                'parameters' => array(
                    'readAdapter'  => 'catalog_read_db',
                    'writeAdapter' => 'catalog_write_db',
                ),
            ),
             'SpeckCatalog\Model\Mapper\ProductMapper' => array(
                'parameters' => array(
                    'readAdapter'  => 'catalog_read_db',
                    'writeAdapter' => 'catalog_write_db',
                ),
            ),              
            'SpeckCatalog\Model\Mapper\AvailabilityMapper' => array(
                'parameters' => array(
                    'readAdapter'  => 'catalog_read_db',
                    'writeAdapter' => 'catalog_write_db',
                ),
            ),
            'SpeckCatalog\Model\Mapper\CompanyMapper' => array(
                'parameters' => array(
                    'readAdapter'  => 'catalog_read_db',
                    'writeAdapter' => 'catalog_write_db',
                ),
            ),
        ),
    ),
);
