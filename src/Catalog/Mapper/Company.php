<?php

namespace Catalog\Mapper;

class Company extends AbstractMapper
{
    protected $tableName = 'contact_company';
    protected $relationalModel = '\Catalog\Model\Company\Relational';
    protected $dbModel = '\Catalog\Model\Company';
    protected $key = array('company_id');

    public function find($companyId)
    {
        $select = $this->getSelect()
            ->from($this->getTableName())
            ->where(array('company_id' => (int) $companyId));
        return $this->selectOne($select);
    }
}
