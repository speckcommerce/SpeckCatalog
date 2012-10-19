<?php

namespace Catalog\Model;
use SpeckContact\Entity\Company as ContactCompany;

class Company extends ContactCompany
{
    protected $name = '';

    public function __toString()
    {
        return $this->getName();
    }
}
