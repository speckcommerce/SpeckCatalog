<?php

namespace SpeckCatalog\Service;

use SpeckCatalog\Model\Product\Relational as RelationalProduct;
use SpeckCatalog\Model\Choice\Relational as RelationalChoice;

class Option extends AbstractService
{
    protected $entityMapper = 'speckcatalog_option_mapper';
    protected $choiceService;
    protected $imageService;
    protected $productService;

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

    public function getBuildersByProductId($productId)
    {
        $choices = $this->getEntityMapper()->getBuildersByProductId($productId);
        $builders = array();
        foreach ($choices as $choice) {
            $builders[$choice['product_id']][] = $choice['choice_id'];
        }
        return $builders;
    }

    public function populate($option, $recursive=false)
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
        $option->setImages($this->getImageService()->getImages('option', $option->getOptionId()));
    }

    public function insert($option)
    {
        $parentType = null;
        if (is_array($option)) {
            if ($option['choice_id']) {
                $parentType = 'choice';
                $choiceId = (int) $option['choice_id'];
            } elseif ($option['product_id']) {
                $parentType = 'product';
                $productId = (int) $option['product_id'];
            } else {
                throw new \Exception('didnt get a product_id or choice_id');
            }
            unset($option['choice_id']);
            unset($option['product_id']);
        } elseif ($option->getProductId()) {
            $parentType = 'product';
            $productId = (int) $option->getProductId();
        } elseif ($option->getChoiceId()) {
            $parentType = 'choice';
            $choiceId = (int) $option->getChoiceId();
        }

        $option = parent::insert($option);

        if($parentType === 'product') {
            $parent = $this->getProductService()->find(array('product_id' => $productId));
            $this->getProductService()->addOption($productId, $option->getOptionId());
            $option->setParent($parent);
        } elseif ($parentType === 'choice') {
            $parent = $this->getChoiceService()->find(array('choice_id' => $choiceId));
            $this->getChoiceService()->addOption($choiceId, $option->getOptionId());
            $option->setParent($parent);
        }

        return $option;
    }

    public function update($option, array $originalValues = null)
    {
        if (null === $originalValues && is_array($option)) {
            $originalValues['option_id'] = $option['option_id'];
        }
        if (null === $originalValues && $option instanceOf \SpeckCatalog\Model\Option) {
            $originalValues['option_id'] = $option->getOptionId();
        }
        parent::update($option, $originalValues);
    }

    public function removeChoice($choiceOrId)
    {
        $choiceId = ( is_int($choiceOrId) ? $choiceOrId : $choiceOrId->getChoiceId() );
        $this->getChoiceService()->delete($choiceId);
    }

    public function sortChoices($optionId, $order)
    {
        return $this->getEntityMapper()->sortChoices($optionId, $order);
    }

    /**
     * @return choiceService
     */
    public function getChoiceService()
    {
        if (null === $this->choiceService) {
            $this->choiceService = $this->getServiceLocator()->get('speckcatalog_choice_service');
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

    /**
     * @return imageService
     */
    public function getImageService()
    {
        if (null === $this->imageService) {
            $this->imageService = $this->getServiceLocator()->get('speckcatalog_option_image_service');
        }
        return $this->imageService;
    }

    /**
     * @param $imageService
     * @return self
     */
    public function setImageService($imageService)
    {
        $this->imageService = $imageService;
        return $this;
    }

    /**
     * @return productService
     */
    public function getProductService()
    {
        if (null === $this->productService) {
            $this->productService = $this->getServiceLocator()->get('speckcatalog_product_service');
        }
        return $this->productService;
    }

    /**
     * @param $productService
     * @return self
     */
    public function setProductService($productService)
    {
        $this->productService = $productService;
        return $this;
    }
}
