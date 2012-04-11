<?php

namespace Catalog\Model;

class Availability extends ModelAbstract
{

    protected $availabilityId;

    protected $distributorCompanyId;
    protected $distributor;
    protected $companies;

    protected $cost = 0;
    
    protected $parentProductUomId;
    protected $parentProductUom;

    public function getQuantity()
    {
        return $this->quantity;
    }
 
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }
 
    public function getCost()
    {
        return $this->cost;
    }
 
    public function setCost($cost)
    {
        $this->cost = (float) $cost;
        return $this;
    }
 
    public function getDistributor()
    {
        return $this->distributor;
    }
 
    public function setDistributor(Company $distributor=null)
    {
        $this->distributor = $distributor;
        return $this;
    }
 
    public function setAvailabilityId($availabilityId)
    {
        $this->availabilityId = $availabilityId;
        return $this;
    }
 
    public function getAvailabilityId()
    {
        return $this->availabilityId;
    }

    public function getParentProductUomId()
    {
        return $this->parentProductUomId;
    }
 
    public function setParentProductUomId($parentProductUomId)
    {
        $this->parentProductUomId = $parentProductUomId;
        return $this;
    }

    public function getDistributorCompanyId()
    {
        return $this->distributorCompanyId;
    }

    public function setDistributorCompanyId($distributorCompanyId)
    {
        $this->distributorCompanyId = (int) $distributorCompanyId;
        return $this;
    }
 
    public function getCompanies()
    {
        return $this->companies;
    }
 
    public function setCompanies($companies)
    {
        $this->companies = $companies;
        return $this;
    }

    public function __toString()
    {
        $string = "";
        $company = $this->getDistributor();
        if($company){
            $string .= $company->getName() . ' - $' . number_format($this->getCost(),2);
        }
        return $string;
    }

    public function getId()
    {
        return $this->getAvailabilityId();
    }    

    public function setId($id)
    {
        return $this->setAvailabilityId($id);
    }
}
