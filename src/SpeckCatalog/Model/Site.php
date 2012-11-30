<?php

namespace SpeckCatalog\Model;

class Site extends AbstractModel
{
    protected $websiteId;
    protected $name;

    /**
     * @return websiteId
     */
    public function getSiteId()
    {
        return $this->websiteId;
    }

    /**
     * @param $websiteId
     * @return self
     */
    public function setWebsiteId($websiteId)
    {
        $this->websiteId = (int) $websiteId;
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
