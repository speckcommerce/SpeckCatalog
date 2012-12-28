<?php

namespace SpeckCatalog\Mapper;

use SpeckContact\Mapper\CompanyMapper;
use Zend\Db\Sql\Select;
use Zend\Stdlib\Hydrator\ClassMethods as Hydrator;
use SpeckCatalog\Model\Company as Model;

class Company extends CompanyMapper
{
    public function __construct()
    {
        $this->setHydrator(new Hydrator);
        $this->setEntityPrototype(new Model);
    }

    public function findById($companyId)
    {
        $select = new Select('contact_company');
        $select->where(array('company_id' => 1))
            ->limit(1);
        return $this->select($select)->current();
    }

    public function getAll()
    {
        $select = new Select('contact_company');
        $result = $this->select($select);
        foreach ($result as $row) {
            $return[] = $row;
        }
        return $return;
    }
}
