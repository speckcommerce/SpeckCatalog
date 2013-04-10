<?php

namespace SpeckCatalog\Service;

class Availability extends AbstractService
{
    protected $entityMapper = 'speckcatalog_availability_mapper';
    protected $companyService;

    public function getByProductUom($productId, $uomCode, $quantity)
    {
        return $this->getEntityMapper()->getByProductUom($productId, $uomCode, $quantity);
    }

    public function populate($availability, $recursive=false)
    {
        $companyId = $availability->getDistributorId();
        $company = $this->getCompanyService()->find(array('company_id' => $companyId));
        $availability->setDistributor($company);
        return $availability;
    }

    public function insert($availability)
    {
        parent::insert($availability);
        return $availability;
    }

    public function getCompanyService()
    {
        if (null === $this->companyService) {
            $this->companyService = $this->getServiceLocator()->get('speckcatalog_company_service');
        }
        return $this->companyService;
    }

    public function setCompanyService($companyService)
    {
        $this->companyService = $companyService;
        return $this;
    }
}
