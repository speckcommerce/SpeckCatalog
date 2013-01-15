<?php

namespace SpeckCatalog\Mapper;

class Builder extends AbstractMapper
{
    protected $tableName = 'catalog_product_builder';
    protected $tableFields = array('product_id', 'choice_id');

    public function find(array $data)
    {
        //todo:this
        return false;
    }
}
