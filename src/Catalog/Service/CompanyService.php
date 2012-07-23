<?php

namespace Catalog\Service;

class CompanyService extends ServiceAbstract
{
    public function _populateModel($company)
    {
        return $company;
    }

    public function getModelMapper()
    {
        if(null === $this->modelMapper){
            $this->modelMapper = $this->getServiceManager()->get('catalog_company_mapper');
        }
        return $this->modelMapper;
    }
}
