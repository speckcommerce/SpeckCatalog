<?php

namespace SpeckCatalog\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="catalog_company")
 */
class Company
{
    /**
     * @ORM\Id
     * @ORM\Column(name="company_id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $companyId;

    /**
     * @ORM\Column(type="string", length=32)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=32)
     */
    protected $phone;

    /**
     * @ORM\Column(type="string")
     */
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
        $this->companyId = $companyId;
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
