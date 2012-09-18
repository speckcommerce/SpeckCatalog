<?php

namespace Catalog\Entity;

class Company extends AbstractEntity
{
    protected $companyId;
    protected $name;

    /**
     * @return companyId
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * @param $companyId
     * @return self
     */
    public function setCompanyId($companyId)
    {
        $this->companyId = $companyId;
        return $this;
    }

    /**
     * @return name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
}
