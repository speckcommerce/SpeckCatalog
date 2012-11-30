<?php

namespace SpeckCatalog\Mapper;

class Availability extends AbstractMapper
{
    protected $tableName = 'catalog_availability';
    protected $relationalModel = '\SpeckCatalog\Model\Availability\Relational';
    protected $dbModel = '\SpeckCatalog\Model\Availability';
    protected $key = array('product_id', 'uom_code', 'quantity', 'distributor_id');
    protected $dbFields = array('product_id', 'uom_code', 'distributor_id', 'cost', 'quantity');

    public function find(array $data)
    {
        $where = array(
            'product_id'     => $data['product_id'],
            'uom_code'       => $data['uom_code'],
            'quantity'       => $data['quantity'],
            'distributor_id' => $data['distributor_id'],
        );
        $select = $this->getSelect()
            ->where($where);
        return $this->selectOne($select);
    }

    public function getByProductUom($productId, $uomCode, $quantity)
    {
        $where = array(
            'product_id' => $productId,
            'uom_code'   => $uomCode,
            'quantity'   => $quantity,
        );
        $select = $this->getSelect()
            ->where($where);
        return $this->selectMany($select);
    }
}
