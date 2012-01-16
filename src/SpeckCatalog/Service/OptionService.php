<?php

namespace SpeckCatalog\Service;

class OptionService
{
    protected $optionMapper;
    
    public function getOptionById($id)
    {
        return $this->optionMapper->getOptionById($id);
    }
    
    public function updateModelFromArray($arr)
    {
        $option = $this->optionMapper->instantiateModel($arr);
        return $this->optionMapper->update($option)->toArray();
    }  
    
    public function getModelsBySearchData($string)
    {
        return $this->optionMapper->getModelsBySearchData($string);
    }
    public function linkOptionToProduct($productId, $optionId)
    {
        $this->optionMapper->linkOptionToProduct($productId, $optionId);
    }    

    public function add($option)
    {
        $this->optionMapper->add($option);
    }

    public function update($option)
    {
        $this->optionMapper->update($option);
    }

    public function getOptionMapper()
    {
        return $this->optionMapper;
    }

    public function setOptionMapper($optionMapper)
    {
        $this->optionMapper = $optionMapper;
        return $this;
    }
}
