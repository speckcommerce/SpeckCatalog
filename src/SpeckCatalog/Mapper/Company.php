<?php

namespace SpeckCatalog\Mapper;

class Company extends AbstractMapper
{
    protected $tableName = 'contact_company';
    protected $relationalModel = '\SpeckCatalog\Model\Company\Relational';
    protected $dbModel = '\SpeckCatalog\Model\Company';
    protected $key = array('company_id');

    public function find($companyId)
    {
        $where = array('company_id' => (int) $companyId);
        return parent::find($where);
    }
}
