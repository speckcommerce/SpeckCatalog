<?php

namespace SpeckCatalog\Mapper\Hydrator;

use SpeckCatalog\Model\Option as Model;
use Zend\Stdlib\Hydrator\ClassMethods;

class Option extends ClassMethods
{
    public function extract(Model $model)
    {
        $data['option_id']      = $model->getOptionId();
        $data['name']           = $model->getName();
        $data['instruction']    = $model->getInstruction();
        $data['required']       = ($model->getRequired()) ? 1 : 0;
        $data['builder']        = ($model->getBuilder())  ? 1 : 0;
        $data['option_type_id'] = $model->getOptionTypeId();

        return $data;
    }

    public function hydrate(array $data, $model)
    {
        $model = parent::hydrate($data, $model);
        $model->setRequired((bool) $model->getRequired());
        $model->setBuilder((bool) $model->getBuilder());

        return $model;
    }
}
