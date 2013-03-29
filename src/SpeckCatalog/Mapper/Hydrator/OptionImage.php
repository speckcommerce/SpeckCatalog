<?php

namespace SpeckCatalog\Mapper\Hydrator;

use SpeckCatalog\Model\OptionImage as Model;
use Zend\Stdlib\Hydrator\ClassMethods;

class OptionImage extends ClassMethods
{
    public function extract(Model $model)
    {
        $data['image_id']    = $model->getImageId();
        $data['option_id']   = $model->getOptionId();
        $data['sort_weight'] = $model->getSortWeight();
        $data['file_name']   = $model->getFileName();
        $data['label']       = $model->getLabel();

        return $data;
    }
}
