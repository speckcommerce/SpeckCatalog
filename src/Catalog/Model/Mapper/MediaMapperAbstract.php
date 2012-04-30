<?php
namespace Catalog\Model\Mapper;
use ArrayObject;
abstract class MediaMapperAbstract extends ModelMapperAbstract
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
    
    public function getMediaByProductId($productId)
    {
        $select = $this->newSelect();
        $select->from($this->getTableName())
            ->join(
                $this->getLinkerTableName(), 
                $this->getTableName() . '.' . $this->getIdField() 
                    . ' = ' . $this->getLinkerTableName() . '.' . $this->getIdField()
            )
            ->where(array('product_id' => $productId));
            //->order('sort_weight DESC');
        $this->events()->trigger(__FUNCTION__, $this, array('select' => $select));   
        $rowset = $this->getTable()->selectWith($select);

        return $this->rowsetToModels($rowset);     
    }    
}
