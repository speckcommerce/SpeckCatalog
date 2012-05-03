<?php
namespace Catalog\Service;
interface ServiceInterface
{
    public function _populateModel($model);
    public function getModelMapper();
}
