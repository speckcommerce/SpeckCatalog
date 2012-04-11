<?php
namespace Catalog\Model\Mapper;
use ArrayObject;
abstract class MediaMapperAbstract extends DbMapperAbstract
{
    protected $tableName = 'catalog_media';

    public function getIdField()
    {
        return 'media_id';
    }   
    
    public function getLinkerTableName()
    {
        return $this->linkerTableName;
    }
}
