<?php

namespace SpeckCatalog\Service;

class Feature extends AbstractService
{
    protected $entityMapper = 'speckcatalog_feature_mapper';

    public function getFeatures($productId)
    {
        return $this->getEntityMapper()->getByProductId($productId);
    }
}
