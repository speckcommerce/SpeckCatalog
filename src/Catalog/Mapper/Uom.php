<?php

namespace Catalog\Mapper;

class Uom extends AbstractMapper
{
    protected $tableName = 'ansi_uom';
    protected $entityPrototype = '\Catalog\Entity\Uom';
    protected $hydrator = 'Catalog\Hydrator\Uom';
}
