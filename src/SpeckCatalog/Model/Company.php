<?php

namespace SpeckCatalog\Model;

class Company extends ModelAbstract
{
    protected $companyId;

    protected $name;

    protected $phone;
    
    protected $email;

    protected $products = array();

    protected $availabilities = array();

    public function getName()
    {
        return $this->name;
    }
 
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
 
    public function getPhone()
    {
        return $this->phone;
    }
 
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }
 
    public function getEmail()
    {
        return $this->email;
    }
 
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
 
    public function setCompanyId($companyId)
    {
        $this->companyId = (int) $companyId;
        return $this;
    }
 
    public function getCompanyId()
    {
        return $this->companyId;
    }
 
    public function getProducts()
    {
        return $this->products;
    }
 
    public function setProducts($products)
    {
        $this->products = $products;
        return $this;
    }
 
    public function getAvailabilities()
    {
        return $this->availabilities;
    }
 
    public function setAvailabilities($availabilities)
    {
        $this->availabilities = $availabilities;
        return $this;
    }
}
