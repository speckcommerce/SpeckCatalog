<?php

namespace Catalog\Model;

class Availability extends ModelAbstract
{
    protected $distributorId;

    /**
     * distributor
     *
     * @var model Catalog\Model\Distributor
     * @access protected
     */
    protected $distributor;

    /**
     * companies
     *
     * @var array
     * @access protected
     */
    protected $companies;

    /**
     * cost
     *
     * @var float
     * @access protected
     */
    protected $cost = 0;

    /**
     * parentProductUomId
     *
     * @var int
     * @access protected
     */
    protected $parentProductUomId;

    /**
     * parentProductUom
     *
     * @var model Catalog\Model\ProductUom
     * @access protected
     */
    protected $parentProductUom;

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

    public function getParentProductUomId()
    {
        return $this->parentProductUomId;
    }

    public function setParentProductUomId($parentProductUomId)
    {
        $this->parentProductUomId = $parentProductUomId;
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

    /**
     * @return distributorId
     */
    public function getDistributorId()
    {
        return $this->distributorId;
    }

    /**
     * @param $distributorId
     * @return self
     */
    public function setDistributorId($distributorId)
    {
        $this->distributorId = $distributorId;
        return $this;
    }
}
