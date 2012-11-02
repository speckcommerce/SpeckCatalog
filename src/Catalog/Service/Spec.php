<?php

namespace Catalog\Service;

class Spec extends AbstractService
{
    protected $entityMapper = 'catalog_spec_mapper';

    public function find(array $data, $populate=false, $recursive=false)
    {
        $spec = $this->getEntityMapper()->find($data);
        if($populate) {
            $this->populate($spec, $recursive);
        }
        return $spec;
    }

    public function getByProductId($productId)
    {
        return $this->getEntityMapper()->getByProductId($productId);
    }

    public function insert($spec)
    {
        $id = parent::insert($spec);
        $spec = $this->find(array('spec_id' => $id));

        return $spec;
    }
}
