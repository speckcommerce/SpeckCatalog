<?php

namespace Catalog\Service;

class Availability extends AbstractService
{
    protected $entityMapper = 'catalog_availability_mapper';

    public function getByProductUom($productId, $uomCode, $quantity)
    {
        return $this->getEntityMapper()->getByProductUom($productId, $uomCode, $quantity);
    }
}
