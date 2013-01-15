<?php

namespace SpeckCatalog\Mapper;

class Uom extends AbstractMapper
{
    protected $tableName = 'ansi_uom';
    protected $model = '\SpeckCatalog\Model\Uom\Relational';
    protected $tableKeyFields = array('uom_code');

    public function find(array $data)
    {
        $where = array('uom_code' => $data['uom_code']);
        return parent::find($where);
    }
}
