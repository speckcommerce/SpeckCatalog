<?php

namespace SpeckCatalog\Mapper;

class Feature extends AbstractMapper
{
    protected $tableName = 'catalog_product_feature';
    protected $relationalModel = 'SpeckCatalog\Model\Feature\Relational';
    protected $dbModel = 'SpeckCatalog\Model\Feature';
}
