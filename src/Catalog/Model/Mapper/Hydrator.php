<?php

namespace Catalog\Model\Mapper;

use Zend\Stdlib\Hydrator\ClassMethods,
    Zend\Stdlib\Hydrator\HydratorInterface;

class Hydrator extends ClassMethods implements HydratorInterface
{
    public function hydrate(array $row, $model)
    {
        if(is_callable($model, 'setLinkerId')){
            $model->setLinkerId( (int) $row['linker_id'] );
        }

        if(isset($row['record_id'])){
            $model->setRecordId( (int) $row['record_id'] );
        }
        return parent::hydrate($row, $model);
    }

    public function extract($model)
    {
        return parent::extract($model);
    }
}
