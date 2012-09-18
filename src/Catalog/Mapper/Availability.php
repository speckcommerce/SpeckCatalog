<?php

namespace Catalog\Mapper;

class Availability extends AbstractMapper
{
    protected $tableName = 'catalog_availability';
    protected $entityPrototype = '\Catalog\Entity\Availability';
    protected $hydrator = 'Catalog\Hydrator\Availability';


    public function find($productId, $uomCode, $quantity, $distributorId)
    {
        $where = array(
            'product_id'     => $productId,
            'uom_code'       => $uomCode,
            'quantity'       => $quantity,
            'distributor_id' => $distributorId,
        );
        $select = $this->getSelect()
            ->from($this->getTableName())
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
            ->from($this->getTableName())
            ->where($where);
        return $this->selectMany($select);
    }

    public function persist($availability)
    {
        $existing = self::find(
            $availability->getProductId(),
            $availability->getUomCode(),
            $availability->getQuantity(),
            $availability->getDistributorId()
        );
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
