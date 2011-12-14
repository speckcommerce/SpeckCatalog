<?php

namespace SpeckCatalogManager\Entity;
use \SpeckCatalog as Catalog;
class Company extends Catalog\Entity\Company
{
    public function __toString()
    {
        return "Company toString";
    }

}
