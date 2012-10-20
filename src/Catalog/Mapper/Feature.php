<?php

namespace Catalog\Mapper;

class Feature extends AbstractMapper
{
    protected $tableName = 'catalog_product_feature';
    protected $relationalModel = 'Catalog\Model\Feature\Relational';
    protected $dbModel = 'Catalog\Model\Feature';
}
