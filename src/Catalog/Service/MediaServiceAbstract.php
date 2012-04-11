<?php
namespace Catalog\Service;
abstract class MediaServiceAbstract extends ServiceAbstract
{
    protected $mediaType = null;

    public function populateModel($model)
    {
        return $model;
    }
}
