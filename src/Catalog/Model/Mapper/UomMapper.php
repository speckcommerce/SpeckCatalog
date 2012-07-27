<?php

namespace Catalog\Model\Mapper;

use Catalog\Model\Uom,
    ArrayObject;

class UomMapper extends ModelMapperAbstract
{
    protected $primaryKey = 'uom_code';
    protected $tableName = 'ansi_uom';

    public function getModel($constructor = null)
    {
        return new Uom($constructor);
    }

    public function getIdField()
    {
        return 'uom_code';
    }
}
