<?php

namespace Catalog\Service;

class Company extends AbstractService
{
    protected $entityMapper = 'catalog_company_mapper';

    public function find($companyId)
    {
        return $this->getEntityMapper()->find($companyId);
    }
}

