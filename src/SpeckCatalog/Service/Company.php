<?php

namespace Catalog\Service;

class Company extends AbstractService
{
    protected $entityMapper = 'catalog_company_mapper';

    public function findById($companyId)
    {
        return $this->find(array('company_id' => $companyId));
    }
}
