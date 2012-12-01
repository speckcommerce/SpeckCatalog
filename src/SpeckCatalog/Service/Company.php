<?php

namespace SpeckCatalog\Service;

class Company extends AbstractService
{
    protected $entityMapper = 'speckcatalog_company_mapper';

    public function findById($companyId)
    {
        return $this->find(array('company_id' => $companyId));
    }
}
