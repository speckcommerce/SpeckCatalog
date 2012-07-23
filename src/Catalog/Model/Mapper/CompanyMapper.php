<?php

namespace Catalog\Model\Mapper;

use Catalog\Model\Company,
    ArrayObject;

class CompanyMapper extends ModelMapperAbstract
{
    protected $tableName = 'catalog_company';

    public function __construct($adapter)
    {
        $unsetKeys = array('products', 'availabilities');
        parent::__construct($adapter, $unsetKeys);
    }

    public function getModel($constructor = null)
    {
        return new Company($constructor);
    }
}
