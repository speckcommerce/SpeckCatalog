<?php

namespace SpeckCatalog\Form;

class Builder extends AbstractForm
{
    protected $originalFields = array();

    public function __construct($options = array())
    {
        parent::__construct();
    }

    public function init($builderProduct)
    {
        $options = $builderProduct['options'];
        $productId = $builderProduct['product_id'];
        $parentProductId = $builderProduct['parent_product_id'];

        $products = array();
        foreach ($options as $optionId => $option) {
            ini_set('html_errors',1);
            $name = 'products[' . $productId . ']['.$optionId.']';
            $products[$productId][$optionId] = $option['selected'];
            $this->add(array(
                'name' => $name,
                'type' => 'Zend\Form\Element\Select',
                'attributes' => array(
                    'type' => 'select',
                    'options' => $option['choices'],
                ),
                'options' => array(
                    'label' => ''
                ),
            ));
            $this->get($name)->setValue($option['selected']);
            $this->get($name)->setEmptyOption('-- ' . $option['name'] . ' --');
        }
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'product_id',
            'attributes' => array(
                'type' => 'hidden',
            ),
            'options' => array(
                'label' => '',
            ),
        ));
        $this->get('product_id')->setValue($options['product_id']);
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'parent_product_id',
            'attributes' => array(
                'type' => 'hidden',
            ),
            'options' => array(
                'label' => '',
            ),
        ));
        $this->get('product_id')->setValue($builderProduct['parent_product_id']);
        $this->setData(array(
            'products'          => $products,
            'product_id'        => $productId,
            'parent_product_id' => $parentProductId,
        ));
    }
}
