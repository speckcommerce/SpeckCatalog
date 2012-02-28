<?php

namespace Catalog\Model\Mapper;

use Catalog\Model\Company, 
    ArrayObject;

class CompanyMapper extends DbMapperAbstract
{
    protected $tableName = 'catalog_company';
    
    public function getModel($constructor = null)
    {
        return new Company($constructor);
    }
}
