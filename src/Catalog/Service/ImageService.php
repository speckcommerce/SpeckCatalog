<?php
namespace Catalog\Service;
class ImageService extends MediaServiceAbstract
{
    public function newProductImage($productId)
    {
        return $this->getModelMapper()->newModel();
    }

    public function getImagesByProductId($productId)
    {
        return $this->getModelMapper()->getImagesByProductId($productId);
    }  
}
