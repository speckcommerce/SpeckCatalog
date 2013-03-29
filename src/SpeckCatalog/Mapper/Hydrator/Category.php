<?php

namespace SpeckCatalog\Mapper\Hydrator;

use SpeckCatalog\Model\Category as Model;
use Zend\Stdlib\Hydrator\ClassMethods;

class Category extends ClassMethods
{
    public function extract(Model $model)
    {
        $data['category_id']      = $model->getCategoryId();
        $data['name']             = $model->getName();
        $data['seo_title']        = $model->getSeoTitle();
        $data['description_html'] = $model->getDescriptionHtml();
        $data['image_file_name']  = $model->getImageFileName();

        return $data;
    }
}
