<?php
namespace Catalog\Model\Mapper;
use ArrayObject;
abstract class MediaMapperAbstract extends ModelMapperAbstract
{
    protected $tableName = 'catalog_media';
    protected $linkerTable;

    public function getIdField()
    {
        return 'media_id';
    }   

    public function getMediaByProductId($productId)
    {
        $select = $this->newSelect();
        $select->from($this->getTableName())
            ->join(
                $this->getLinkerTable()->getTableName(), 
                $this->getTableName() . '.' . $this->getIdField() 
                    . ' = ' . $this->getLinkerTable()->getTableName() . '.' . $this->getIdField()
            )
            ->where(array('product_id' => $productId));
            //->order('sort_weight DESC');
        $this->events()->trigger(__FUNCTION__, $this, array('select' => $select));   
        $rowset = $this->getTable()->selectWith($select);

        return $this->rowsetToModels($rowset);     
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
