<?php

namespace SpeckCatalog\Model\Mapper;

use SpeckCatalog\Model\Company, 
    ArrayObject;

class CompanyMapper extends DbMapperAbstract
{
    protected $tableName = 'catalog_company';
    protected $modelClass = 'Company';

    public function instantiateModel($row)
    {
        $company = new Company;
        $company->setCompanyId($row['company_id'])
                     ->setName($row['name']);
                    
        $this->events()->trigger(__FUNCTION__, $this, array('model' => $company));
        return $company;  
    }
}
