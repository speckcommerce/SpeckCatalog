<?php

namespace Catalog\Model\Mapper;

use Catalog\Model\Company,
    ArrayObject;

class CompanyMapper extends ModelMapperAbstract
{
    protected $primaryKey = 'company_id';
    protected $tableName = 'catalog_company';

    public function __construct()
    {
        $unsetKeys = array('products', 'availabilities');
        parent::__construct($unsetKeys);
    }

    public function getModel($constructor = null)
    {
        return new Company($constructor);
    }
}
