<?php

namespace Catalog\Service;

class Feature extends AbstractService
{
    protected $entityMapper = 'catalog_feature_mapper';

    public function getFeatures($productId)
    {
        return $this->getEntityMapper()->getFeatures($productId);
    }
}
