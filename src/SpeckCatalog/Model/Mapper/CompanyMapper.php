<?php

namespace SpeckCatalog\Model\Mapper;

use SpeckCatalog\Model\Company, 
    ArrayObject;

class CompanyMapper extends DbMapperAbstract
{
    protected $tableName = 'catalog_company';
    protected $modelClass = 'Company';
}
