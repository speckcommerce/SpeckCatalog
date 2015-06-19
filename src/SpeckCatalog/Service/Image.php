<?php

namespace SpeckCatalog\Service;

class Image extends AbstractService
{
    protected $entityMapper = 'speckcatalog_image_mapper';

    public function getImages($type, $id)
    {
        return $this->getEntityMapper()->getImages($type, $id);
    }

    public function getImageForCategory($id)
    {
        $images = $this->getEntityMapper()->getImages('category', $id);
        $return = null;
        if (count($images) > 0) {
            $return = array_shift($images);
        }
        return $return;
    }
}
