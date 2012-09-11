<?php

namespace Catalog\Mapper;

class Uom extends AbstractMapper
{
    protected $tableName = 'ansi_uom';
    protected $entityPrototype = '\Catalog\Entity\Uom';
    protected $hydrator = 'Catalog\Hydrator\Uom';

    public function find($uomCode)
    {
        $select = $this->select()
            ->from($this->getTableName())
            ->where(array('uom_code' => $uomCode));
        return $this->selectOne($select);
    }
}
