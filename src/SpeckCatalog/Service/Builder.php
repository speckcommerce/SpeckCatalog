<?php

namespace SpeckCatalog\Service;

use SpeckCatalog\Model;
use Zend\Form\Form;

class Builder extends AbstractService
{
    protected $entityMapper = 'speckcatalog_builder_product_mapper';
    protected $productService;


    public function persist(Form $form)
    {
        $data = $form->getData();
        foreach ($data['products'] as $productId => $options) {
            foreach ($options as $optionId => $choiceId) {
                $row = array(
                    'product_id' => $productId,
                    'option_id'  => $optionId,
                    'choice_id'  => $choiceId
                );
                $this->getEntityMapper()->persist($row);
            }
        }

        $builder = $this->newBuilderForProduct($data['product_id'], $data['parent_product_id']);

        return $builder;
    }

    public function getBuildersByProductId($productId)
    {
        $mapper   = $this->getEntityMapper();
        $builders = $mapper->getBuildersByProductId($productId);
        $options = $mapper->getBuilderOptionsByProductId($productId);

        $return = array();
        foreach ($builders as $pid => $opts) {
            $return[$pid]['product_id'] = $pid;
            $return[$pid]['parent_product_id'] = $productId;
            $return[$pid]['product'] = $this->getProduct($pid);
            $return[$pid]['options'] = $options;
            foreach ($opts as $optionId => $choiceId) {
                $return[$pid]['options'][$optionId]['selected'] = $choiceId;
            }
        }

        return $return;
    }

    public function buildersToProductCsv($builders)
    {
        $csv = array();
        foreach($builders as $productId => $product) {
            foreach($product['options'] as $optionId => $option) {
                $csv[$productId][] = $option['selected'];
            }
        }
        foreach($csv as $productId => $choiceIds) {
            $csv[$productId] = implode(',', $choiceIds);
        }
        return $csv;
    }

    public function getProduct($productId)
    {
        return $this->getProductService()->find(array('product_id' => $productId));
    }

    public function newBuilderForProduct($builderProductId, $parentProductId)
    {
        $mapper  = $this->getEntityMapper();
        $options = $mapper->getBuilderOptionsByProductId($parentProductId, $builderProductId);
        $builder = array(
            'product_id'        => $builderProductId,
            'parent_product_id' => $parentProductId,
            'product'           => $this->getProduct($builderProductId),
            'options'           => $options,
        );

        return $builder;
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
