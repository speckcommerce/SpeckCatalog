<?php

namespace Catalog\Mapper;

class Availability extends AbstractMapper
{
    protected $tableName = 'catalog_availability';
    protected $relationalModel = '\Catalog\Model\Availability\Relational';
    protected $dbModel = '\Catalog\Model\Availability';
    protected $key = array('product_id', 'uom_code', 'quantity', 'distributor_id');

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

    public function persist($availability)
    {
        $availability = $this->getDbModel($availability);
        $existing = self::find(array(
            'product_id'     => $availability->getProductId(),
            'uom_code'       => $availability->getUomCode(),
            'quantity'       => $availability->getQuantity(),
            'distributor_id' => $availability->getDistributorId(),
        ));
        if($existing){
            $where = array(
                'product_id'     => $availability->getProductId(),
                'uom_code'       => $availability->getUomCode(),
                'quantity'       => $availability->getQuantity(),
                'distributor_id' => $availability->getDistributorId(),
            );
            return $this->update($availability, $where);
        } else {
            return $this->insert($availability);
        }
    }
}
