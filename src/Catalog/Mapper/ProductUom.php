<?php

namespace Catalog\Mapper;

class ProductUom extends AbstractMapper
{
    protected $tableName = 'catalog_product_uom';
    protected $dbModel = '\Catalog\Model\ProductUom';
    protected $relationalModel = '\Catalog\Model\ProductUom\Relational';
    protected $key = array('product_id', 'uom_code', 'quantity');

    public function find(array $data)
    {
        $where = array(
            'product_id' => $data['product_id'],
            'uom_code'   => $data['uom_code'],
            'quantity'   => $data['quantity'],
        );
        $select = $this->getSelect()           
            ->where($where);
        return $this->selectOne($select);
    }

    public function getByProductId($productId)
    {
        $select = $this->getSelect()
            ->where(array('product_id' => $productId));
        return $this->selectMany($select);
    }

    public function persist($productUom)
    {
        $productUom = $this->getDbModel($productUom);
        $where = array(
            'product_id' => $productUom->getProductId(),
            'uom_code'   => $productUom->getUomCode(),
            'quantity'   => $productUom->getQuantity(),
        );
        $existing = self::find($where);
        if($existing){
            return $this->update($productUom, $where);
        } else {
            $this->insert($productUom);
            return $this->find($where);
        }
    }
}
