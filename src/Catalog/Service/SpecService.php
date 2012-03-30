<?php
namespace Catalog\Service;
class SpecService extends ServiceAbstract
{
    public function newProductSpec($productId)
    {
        $spec = $this->getModelMapper()->newModel();
        $spec->setProductId($productId);
        return $this->getModelMapper()->update($spec);
    }

    public function getByProductId($productId)
    {
        return $this->getModelMapper()->getByProductId($productId);
    }

    public function populateModel($model)
    {
        return $model;
    }
}
