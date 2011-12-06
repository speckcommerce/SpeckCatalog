<?php

namespace Management\Entity;

class Product extends \Catalog\Entity\Product
{
    protected $uomIds;
    protected $companyId;

    public function getUomIds()
    {
        return $this->uomIds;
    }

    public function setUomIds($uomIds)
    {
        $this->uomIds = $uomIds;
        return $this;
    }

    public function getCompanyId()
    {
        return $this->companyId;
    }

    public function setCompanyId($companyId)
    {
        $this->companyId = $companyId;
        return $this;
    }
}
