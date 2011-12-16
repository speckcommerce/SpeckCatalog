<?php

namespace SpeckCatalogManager\Entity;
use \SpeckCatalog\Entity\Company as CatalogCompany;
class Company extends CatalogCompany
{
    public function __toString()
    {
        return "Company toString";
    }

}
