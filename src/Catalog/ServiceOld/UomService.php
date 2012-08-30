<?php

namespace Catalog\Service;

class UomService extends ServiceAbstract
{
    public function _populateModel($uom)
    {
        return $uom;
    }

    public function getModelMapper()
    {
        if(null === $this->modelMapper){
            $this->modelMapper = $this->getServiceManager()->get('catalog_uom_mapper');
        }
        return $this->modelMapper;         
    }  
}
