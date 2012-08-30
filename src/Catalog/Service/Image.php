<?php

namespace Catalog\Service;

class Image extends AbstractService
{
    protected $entityMapper = 'catalog_image_mapper';

    public function getImages($type, $id)
    {
        return $this->getEntityMapper()->getImages($type, $id);
    }
}
