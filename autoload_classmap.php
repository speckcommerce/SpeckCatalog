<?php
return array(

    'Catalog\Controller\IndexController'        => __DIR__ . '/src/Catalog/Controller/IndexController.php',
    'CatalogManager\Controller\IndexController' => __DIR__ . '/src/CatalogManager/Controller/IndexController.php',
    'Catalog\Controller\ErrorController'        => __DIR__ . '/src/Catalog/Controller/ErrorController.php',
    'Catalog\Module'                            => __DIR__ . '/Module.php',

    /**
     * Services
     */
    'Catalog\Service\ServiceAbstract'           => __DIR__ . '/src/Catalog/Service/ServiceAbstract.php',
        'Catalog\Service\ProductService'            => __DIR__ . '/src/Catalog/Service/ProductService.php',
        'Catalog\Service\OptionService'             => __DIR__ . '/src/Catalog/Service/OptionService.php',
        'Catalog\Service\ChoiceService'             => __DIR__ . '/src/Catalog/Service/ChoiceService.php',
        'Catalog\Service\ProductUomService'         => __DIR__ . '/src/Catalog/Service/ProductUomService.php',
        'Catalog\Service\UomService'                => __DIR__ . '/src/Catalog/Service/UomService.php',
        'Catalog\Service\AvailabilityService'       => __DIR__ . '/src/Catalog/Service/AvailabilityService.php',
        'Catalog\Service\CompanyService'            => __DIR__ . '/src/Catalog/Service/CompanyService.php',
    'Catalog\Service\CatalogService'            => __DIR__ . '/src/Catalog/Service/CatalogService.php',
    'Catalog\Service\Installer'                 => __DIR__ . '/src/Catalog/Service/Installer.php',

    /**
     * Mappers
     */
    'Catalog\Model\Mapper\DbMapperAbstract'     => __DIR__ . '/src/Catalog/Model/Mapper/DbMapperAbstract.php',
        'Catalog\Model\Mapper\ProductMapper'        => __DIR__ . '/src/Catalog/Model/Mapper/ProductMapper.php',
        'Catalog\Model\Mapper\OptionMapper'         => __DIR__ . '/src/Catalog/Model/Mapper/OptionMapper.php',
        'Catalog\Model\Mapper\ChoiceMapper'         => __DIR__ . '/src/Catalog/Model/Mapper/ChoiceMapper.php',
        'Catalog\Model\Mapper\ProductUomMapper'     => __DIR__ . '/src/Catalog/Model/Mapper/ProductUomMapper.php',
        'Catalog\Model\Mapper\UomMapper'            => __DIR__ . '/src/Catalog/Model/Mapper/UomMapper.php',
        'Catalog\Model\Mapper\AvailabilityMapper'   => __DIR__ . '/src/Catalog/Model/Mapper/AvailabilityMapper.php',
        'Catalog\Model\Mapper\CompanyMapper'        => __DIR__ . '/src/Catalog/Model/Mapper/CompanyMapper.php',
        'Catalog\Model\Mapper\MYSQL_CatalogMapper'  => __DIR__ . '/src/Catalog/Model/Mapper/MYSQL_CatalogMapper.php',

    /**
     * Models
     */
    'Catalog\Model\ModelAbstract' => __DIR__ . '/src/Catalog/Model/ModelAbstract.php',
        'Catalog\Model\Product'                => __DIR__ . '/src/Catalog/Model/Product.php',
        'Catalog\Model\Option'                 => __DIR__ . '/src/Catalog/Model/Option.php',
            'Catalog\Model\OptionSlider'           => __DIR__ . '/src/Catalog/Model/OptionSlider.php',
        'Catalog\Model\Choice'                 => __DIR__ . '/src/Catalog/Model/Choice.php',
        'Catalog\Model\ProductUom'             => __DIR__ . '/src/Catalog/Model/ProductUom.php',
        'Catalog\Model\Uom'                    => __DIR__ . '/src/Catalog/Model/Uom.php',
        'Catalog\Model\Availability'           => __DIR__ . '/src/Catalog/Model/Availability.php',
        'Catalog\Model\Company'                => __DIR__ . '/src/Catalog/Model/Company.php',

);
