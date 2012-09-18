<?php

namespace Catalog\Service;

class Spec extends AbstractService
{
    protected $entityMapper = 'catalog_spec_mapper';

    public function find($specId)
    {
        return $this->getEntityMapper()->find($specId);
    }

    public function getByProductId($productId)
    {
        return $this->getEntityMapper()->getByProductId($productId);
    }
}
