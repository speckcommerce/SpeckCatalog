<?php

namespace Catalog\Mapper;

class Uom extends AbstractMapper
{
    protected $tableName = 'ansi_uom';
    protected $relationalModel = '\Catalog\Model\Uom\Relational';
    protected $key = array('uom_code');

    public function find(array $data)
    {
        $select = $this->getSelect()
            ->from($this->getTableName())
            ->where(array('uom_code' => $data['uom_code']));
        return $this->selectOne($select);
    }
}
