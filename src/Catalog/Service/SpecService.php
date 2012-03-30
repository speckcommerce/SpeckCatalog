<?php
namespace Catalog\Service;
class SpecService extends ServiceAbstract
{
    public function newProductSpec($productId)
    {
        return $this->getModelMapper()->newModel();
    }

    public function populateModel($model)
    {
        return $model;
    }
}
