<?php

namespace Catalog\Mapper;

use Catalog\Entity\ProductUom as Entity;
use Catalog\Hydrator\ProductUom as Hydrator;

class ProductUom extends AbstractMapper
{
    protected $tableName = 'catalog_product_uom';
    protected $entityPrototype = '\Catalog\Entity\ProductUom';
    protected $hydrator = 'Catalog\Hydrator\ProductUom';

    public function find($productId, $uomCode)
    {
        $select = $this->select()
            ->from($this->getTableName())
            ->where(array('product_id' =>  $productId, 'uom_code' => $uomCode));
        return $this->selectOne($select);
    }

    public function getByProductId($productId)
    {
        $select = $this->select()
            ->from($this->getTableName())
            ->where(array('product_id' => $productId));
        return $this->selectMany($select);
    }
}
