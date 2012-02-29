<?php

namespace Catalog\Service;

class Installer
{
    private $catalogService;

    public function install()
    {
        return $this->getCatalogService()->createCatalog();
    }

    public function getCatalogService()
    {
        return $this->catalogService;
    }
 
    public function setCatalogService($catalogService)
    {
        $this->catalogService = $catalogService;
        return $this;
    }
}   
