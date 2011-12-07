<?php

namespace Management\Entity;

class Product extends \Catalog\Entity\Product
{
    protected $uomIds;
    protected $companyId;
    protected $parentShellId;

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
 
    public function getParentShellId()
    {
        return $this->parentShellId;
    }
 
    public function setParentShellId($parentShellId)
    {
        $this->parentShellId = $parentShellId;
        return $this;
    }
}
