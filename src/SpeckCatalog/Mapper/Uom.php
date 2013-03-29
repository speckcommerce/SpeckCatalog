<?php

namespace SpeckCatalog\Mapper;

class Uom extends AbstractMapper
{
    protected $tableName = 'ansi_uom';
    protected $model = '\SpeckCatalog\Model\Uom\Relational';
    protected $tableKeyFields = array('uom_code');
    protected $hydrator = 'SpeckCatalog\Mapper\Hydrator\Uom';
}
