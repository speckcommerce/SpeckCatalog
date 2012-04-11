<?php
namespace Catalog\Model\Mapper;
use Catalog\Model\Spec;
class SpecMapper extends ModelMapperAbstract
{
    protected $tableName = 'catalog_product_spec';

    public function getModel($constructor=null)
    {
        return new Spec($constructor);
    }

    public function getByProductId($productId)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
                  ->from($this->getTableName())
                  ->where('product_id = ?', $productId);
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));
        $rows = $db->fetchAll($sql);

        $specs = array();
        if(count($rows) > 0 ){
            foreach($rows as $row){
                $specs[] = $this->mapModel($row);
            }
        }  
        return $specs;
    }

}
