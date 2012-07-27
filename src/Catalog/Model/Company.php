<?php

namespace Catalog\Model;

class Company extends ModelAbstract
{
    protected $companyId;

    /**
     * name
     *
     * @var string
     * @access protected
     */
    protected $name;

    /**
     * phone
     *
     * @var string
     * @access protected
     */
    protected $phone;

    /**
     * email
     *
     * @var string
     * @access protected
     */
    protected $email;

    /**
     * products
     *
     * @var array
     * @access protected
     */
    protected $products;

    /**
     * availabilities
     *
     * @var array
     * @access protected
     */
    protected $availabilities;

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

    public function __toString()
    {
        return '';
    }

 /**
  * Get companyId.
  *
  * @return companyId.
  */
 function getCompanyId()
 {
     return $this->companyId;
 }

 /**
  * Set companyId.
  *
  * @param companyId the value to set.
  */
 function setCompanyId($companyId)
 {
     $this->companyId = $companyId;
 }
    public function getId()
    {
        return $this->companyId;
    }
    public function setId($id)
    {
        return $this->setCompanyId($id);
    }
}
