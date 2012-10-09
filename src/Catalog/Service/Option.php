<?php

namespace Catalog\Service;

class Option extends AbstractService
{
    protected $entityMapper = 'catalog_option_mapper';
    protected $choiceService;

    public function getByProductId($productId, $populate=false, $recursive=false)
    {
        $options = $this->getEntityMapper()->getByProductId($productId);
        if ($populate) {
            foreach ($options as $option) {
                $this->populate($option, $recursive);
            }
        }
        return $options;
    }

    public function getByParentChoiceId($choiceId, $populate=false)
    {
        $options = $this->getEntityMapper()->getByParentChoiceId($choiceId);
        if ($populate) {
            foreach ($options as $option) {
                $this->populate($option);
            }
        }
        return $options;
    }

    private function populate($option, $recursive=false)
    {
        $choices = $this->getChoiceService()->getByOptionId($option->getOptionId(), true, $recursive);
        if($choices){
            if($option->getVariation()) {
                $prices = array();
                foreach ($choices as $choice) {
                    $prices[] = $choice->getPrice();
                }
                asort($prices);
                $lowestPrice = array_shift($prices);
                foreach ($choices as $choice) {
                    $choice->setAddPrice($choice->getPrice() - $lowestPrice);
                }
            } else {
                foreach ($choices as $choice) {
                    $choice->setAddPrice($choice->getPrice());
                }
            }
            $option->setChoices($choices);
        }
    }

    public function addChoice($optionOrId, $choice)
    {
        $optionId = ( is_int($optionOrId) ? $optionOrId : $optionOrId->getOptionId() );
        $choice->setOptionId($optionId);
        $this->getChoiceService()->persist($choice);
    }

    public function removeChoice($choiceOrId)
    {
        $choiceId = ( is_int($choiceOrId) ? $choiceOrId : $choiceOrId->getChoiceId() );
        $this->getChoiceService()->delete($choiceId);
    }

    /**
     * @return choiceService
     */
    public function getChoiceService()
    {
        if (null === $this->choiceService) {
            $this->choiceService = $this->getServiceLocator()->get('catalog_choice_service');
        }
        return $this->choiceService;
    }

    /**
     * @param $choiceService
     * @return self
     */
    public function setChoiceService($choiceService)
    {
        $this->choiceService = $choiceService;
        return $this;
    }
}
