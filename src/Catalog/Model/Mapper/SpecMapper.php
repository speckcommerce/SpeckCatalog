<?php
namespace Catalog\Model\Mapper;
use Catalog\Model\Spec;
class SpecMapper extends ModelMapperAbstract
{
    protected $primaryKey = 'spec_id';
    protected $tableName = 'catalog_product_spec';

    public function getModel($constructor=null)
    {
        return new Spec($constructor);
    }

    public function getByProductId($productId)
    {
        $select = $this->select()->from($this->tableName)
            ->where(array('product_id' => $productId));
        return $this->selectMany($select);
    }

    public function removeLinker($id)
    {
        //no linker, delete the actual record!
        return $this->deleteById($id);
    }
}
