<?php
namespace Catalog\Service;
abstract class MediaServiceAbstract extends ServiceAbstract implements MediaServiceInterface
{
    protected $basePath;

    public function populateModel($model)
    {
        $model->setBaseUrl($this->getBasePath());
        return $model;
    }

    public function linkParentProduct($productId, $mediaId)
    {
        $this->getModelMapper()->linkParentProduct($productId, $mediaId);
    }
    
    public function getBasePath()
    {
        return $this->basePath;
    }

    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
        return $this;
    }
}
