<?php

namespace Catalog\Service;

class Uom extends AbstractService
{
    protected $entityMapper = 'catalog_uom_mapper';

    public function find($uomCode)
    {
        return $this->getEntityMapper()->find($uomCode);
    }
}
