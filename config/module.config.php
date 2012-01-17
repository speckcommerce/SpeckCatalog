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
                    'userService'    => 'speckcatalog_user_service',
                    'productService' => 'SpeckCatalog\Service\ProductService',
                    'optionService' => 'SpeckCatalog\Service\OptionService',
                    'choiceService' => 'SpeckCatalog\Service\ChoiceService',
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
                    'optionMapper' => 'SpeckCatalog\Model\Mapper\OptionMapper',
                    'choiceService' => 'SpeckCatalog\Service\ChoiceService',
                ),
            ),          
            'SpeckCatalog\Service\ChoiceService' => array(
                'parameters' => array(
                    'choiceMapper' => 'SpeckCatalog\Model\Mapper\ChoiceMapper',
                    'productMapper' => 'SpeckCatalog\Model\Mapper\ProductMapper',
                ),
            ),
            'SpeckCatalog\Service\ProductService' => array(
                'parameters' => array(
                    'productMapper' => 'SpeckCatalog\Model\Mapper\ProductMapper',
                    'optionService' => 'SpeckCatalog\Service\OptionService',
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
            'SpeckCatalog\Model\Mapper\ProductMapper' => array(
                'parameters' => array(
                    'readAdapter'  => 'catalog_read_db',
                    'writeAdapter' => 'catalog_write_db',
                ),
            ),
        ),
    ),
);
