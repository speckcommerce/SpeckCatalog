<?php

namespace SpeckCatalog\Service;

class ProductUomService extends ServiceAbstract
{
    public function populateModel($productUom)
    {
        return $productUom;
    }

    public function newProductProductUom($parentId)
    {
        $productUom = $this->getModelMapper()->newModel();
        $productUom->setParentProductId($parentId);
        $this->modelMapper->update($productUom);
        return $productUom;    
    }

    public function getProductUomsByParentProductId($id)
    {
        $productUoms = $this->modelMapper->getProductUomsByParentProductId($id);
        $return = array();
        foreach ($productUoms as $productUom){
            $return[] = $this->populateModel($productUom);
        }
        return $return;
    }  
}
