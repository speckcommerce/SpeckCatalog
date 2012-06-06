<?php
namespace Catalog\Model\Mapper;
use ArrayObject;
abstract class MediaMapperAbstract extends ModelMapperAbstract
{
    protected $tableName = 'catalog_media';
    protected $parentProductLinkerTable;

    public function getMediaByProductId($productId)
    {
        $linkerName = $this->getParentProductLinkerTable()->getTableName();
        $select = $this->newSelect();
        $select->from($this->getTableName())
            ->join($linkerName, $this->getTableName() . '.record_id = ' . $linkerName . '.media_id')
            ->where(array('product_id' => $productId));
        //->order('sort_weight DESC');
        return $this->selectMany($select);   
    }    
 
    public function setParentProductLinkerTable($parentProductLinkerTable)
    {
        $this->parentProductLinkerTable = $parentProductLinkerTable;
        return $this;
    }
}
