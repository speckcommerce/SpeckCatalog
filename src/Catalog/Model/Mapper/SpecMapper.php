<?php
namespace Catalog\Model\Mapper;
use Catalog\Model\Spec;
class SpecMapper extends ModelMapperAbstract
{
    public function getModel($constructor=null)
    {
        return new Spec($constructor);
    }

    public function getByProductId($productId)
    {
        $select = $this->newSelect();
        $select->from($this->getTable()->getTableName())
            ->where(array('product_id' => $productId));
        $this->events()->trigger(__FUNCTION__, $this, array('select' => $select));   
        $rowset = $this->getTable()->selectWith($select);

        return $this->rowsetToModels($rowset);   
    }

    public function old_getByProductId($productId)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
                  ->from($this->getTableName())
                  ->where('product_id = ?', $productId);
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));
        $rows = $db->fetchAll($sql);

        return $this->rowsToModels($rows);
    }
   
    public function removeLinker($id)
    {
        //no linker, delete the actual record!
        return $this->deleteById($id);
    }    
}
