<?php
namespace Catalog\Model\Mapper;
use ArrayObject;
abstract class MediaMapperAbstract extends ModelMapperAbstract
{
    protected $tableName = 'catalog_media';
    protected $linkerTable;

    public function getMediaByProductId($productId)
    {
        $select = $this->newSelect();
        $select->from($this->getTableName())
            ->join(
                $this->getLinkerTable()->getTableName(), 
                $this->getTableName() . '.record_id = ' . $this->getLinkerTable()->getTableName() . '.media_id' 
            )
            ->where(array('product_id' => $productId));
        //->order('sort_weight DESC');
        return $this->selectMany($select);   
    }    
 
    public function getLinkerTable()
    {
        return $this->linkerTable;
    }        

    public function setLinkerTable($linkerTable)
    {
        $this->linkerTable = $linkerTable;
        return $this;
    }
}
