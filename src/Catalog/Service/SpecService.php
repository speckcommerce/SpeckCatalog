<?php
namespace Catalog\Service;
class SpecService extends ServiceAbstract
{
    public function _populateModel($model)
    {
        return $model;
    }

    public function newProductSpec($productId)
    {
        $spec = $this->getModelMapper()->getModel();
        $spec->setProductId($productId);
        return $this->add($spec);
    }

    public function getByProductId($productId)
    {
        return $this->getModelMapper()->getByProductId($productId);
    }
}
