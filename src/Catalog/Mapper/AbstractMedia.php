<?php

namespace Catalog\Mapper;

class AbstractMedia extends AbstractMapper
{
    protected $tableName = 'catalog_media';
    protected $entityPrototype = '\Catalog\Entity\Media';
    protected $hydrator = 'Catalog\Hydrator\Media';
}
