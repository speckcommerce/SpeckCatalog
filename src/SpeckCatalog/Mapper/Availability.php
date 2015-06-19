<?php

namespace SpeckCatalog\Mapper;

class Availability extends AbstractMapper
{
    protected $tableName = 'catalog_availability';
    protected $model = '\SpeckCatalog\Model\Availability\Relational';
    protected $tableKeyFields = array(
        'product_id',
        'uom_code',
        'quantity',
        'distributor_id'
    );
    protected $tableFields = array(
        'product_id',
        'uom_code',
        'distributor_id',
        'cost',
        'quantity',
        'distributor_uom_code',
        'distributor_item_number'
    );

    public function getByProductUom($productId, $uomCode, $quantity)
    {
        $where = array(
            'product_id' => $productId,
            'uom_code'   => $uomCode,
            'quantity'   => $quantity,
        );
        $select = $this->getSelect()
            ->where($where);
        return $this->selectManyModels($select);
    }
}
