<?php

namespace Catalog\Mapper;

class ProductUom extends AbstractMapper
{
    protected $tableName = 'catalog_product_uom';
    protected $entityPrototype = '\Catalog\Entity\ProductUom';
    protected $hydrator = 'Catalog\Hydrator\ProductUom';

    public function find($productId, $uomCode, $quantity)
    {
        $where = array(
            'product_id' => $productId,
            'uom_code'   => $uomCode,
            'quantity'   => $quantity,
        );
        $select = $this->select()
            ->from($this->getTableName())
            ->where($where);
        return $this->selectOne($select);
    }

    public function getByProductId($productId)
    {
        $select = $this->select()
            ->from($this->getTableName())
            ->where(array('product_id' => $productId));
        return $this->selectMany($select);
    }

    public function persist($productUom)
    {
        $existing = self::find($productUom->getProductId(), $productUom->getUomCode(), $productUom->getQuantity());
        if($existing){
            $where = array(
                'product_id' => $productUom->getProductId(),
                'uom_code'   => $productUom->getUomCode(),
                'quantity'   => $productUom->getQuantity(),
            );
            return $this->update($productUom, $where);
        } else {
            return $this->insert($productUom);
        }
    }
}
