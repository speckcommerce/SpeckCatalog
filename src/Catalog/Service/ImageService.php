<?php
namespace Catalog\Service;
class ImageService extends MediaServiceAbstract
{
    public function populateModel($model)
    {
        $model->setBaseUrl('http://cdn.yoursite.com/images/');
        return $model;
    }
    
    public function newProductImage($productId)
    {
        return $this->getModelMapper()->newModel();
    }

    public function getImagesByProductId($productId)
    {
        $images = $this->getModelMapper()->getImagesByProductId($productId);
        foreach($images as $i => $image){
            $images[$i] = $this->populateModel($image);
        }
        return $images;
    }  
}
