<?php

namespace SpeckCatalog\Mapper\Hydrator;

use SpeckCatalog\Model\Uom as Model;
use Zend\Stdlib\Hydrator\ClassMethods;

class Uom extends ClassMethods
{
    public function extract(Model $model)
    {
        $data['uom_code'] = $model->getUomCode();
        $data['name']     = $model->getName();
        $data['enabled']  = ($model->getEnabled()) ? 1 : 0;

        return $data;
    }

    public function hydrate($data, $model)
    {
        $model = parent::hydrate($data, $model);
        $model->setEnabled( (bool) $model->getEnabled());

        return $model;
    }
}
