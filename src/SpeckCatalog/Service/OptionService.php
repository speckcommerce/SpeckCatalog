<?php

namespace SpeckCatalog\Service;

class OptionService extends ServiceAbstract
{
    protected $choiceService;
    
    public function getOptionsByProductId($productId)
    {
        $options = $this->modelMapper->getOptionsByProductId($productId);
        $return = array();
        foreach($options as $option){
            $return[] = $this->populateModel($option);
        }
        return $return;
    }

    public function getOptionsByChoiceId($choiceId)
    {
        $options = $this->modelMapper->getOptionsByChoiceId($choiceId);
        $return = array();
        foreach($options as $option){
            $return[] = $this->populateModel($option);
        }
        return $return;
    }

    public function populateModel($option)
    {
        $choices = $this->getChoiceService()->getChoicesByParentOptionId($option->getOptionId());
        if($choices){
            $option->setChoices($choices);
        }
        return $option;
    }
    
    public function newProductOption($productId)
    {
        $option = $this->newModel();
        $this->getModelMapper()->linkOptionToProduct($productId, $option->getOptionId());
        return $option;
    }

    public function newChoiceOption($choiceId){
        $option = $this->newModel();
        $this->getModelMapper()->linkOptionToChoice($choiceId, $option->getOptionId());
        return $option;    
    }
    
    public function linkParentChoice($choiceId, $optionId)
    {
        $this->getModelMapper()->linkOptionToChoice($choiceId, $optionId);
    }    
    public function linkParentProduct($productId, $optionId)
    {
        $this->getModelMapper()->linkOptionToProduct($productId, $optionId);
    }    

    public function getChoiceService()
    {
        return $this->choiceService;
    }
 
    public function setChoiceService($choiceService)
    {
        $this->choiceService = $choiceService;
        return $this;
    }
}
