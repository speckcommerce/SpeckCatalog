<?php

namespace Catalog\Service;

class ProductUom extends AbstractService
{
    protected $entityMapper = 'catalog_product_uom_mapper';

    public function find()
    {
    }

    public function getByProductId($productId, $populate=false, $recursive=false)
    {
        $productUoms = $this->getEntityMapper()->getByProductId($productId);
        if ($populate) {
            foreach ($productUoms as $productUom) {
                $this->populate($productUom, $recursive);
            }
        }
        return $productUoms;
    }

    public function populate($productUoms)
    {
    }
}
