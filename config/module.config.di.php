<?php
return array(
    'di' => array(
        'instance' => array(

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

            'Zend\View\Resolver\TemplatePathStack' => array(
                'parameters' => array(
                    'paths'  => array(
                        'catalog' => __DIR__ . '/../view',
                    ),
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
        ),
    ),
);      
