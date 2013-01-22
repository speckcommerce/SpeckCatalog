<?php

namespace SpeckCatalog\Form;

class Builder extends AbstractForm
{
    protected $originalFields = array();

    public function __construct($options = array())
    {
        parent::__construct();

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
    }

    public function setData($data)
    {
        $this->data = $data;
        if (isset($data['options'])) {
            if (!isset($data['product_id']) || !isset($data['parent_product_id'])) {
                throw new \RuntimeExecption('didnt get product id or parent');
            }
            $this->addOptions($data['options']);
        }
        parent::setData($this->data);
    }

    public function addOptions($options)
    {
        $productId = $this->data['product_id'];
        foreach ($options as $optionId => $option) {
            $this->data['products'][$productId][$optionId] = $option['selected'];
            $name =  'products['.$productId.']['.$optionId.']';
            $this->add(array(
                'name' => $name,
                'type' => 'Zend\Form\Element\Select',
                'attributes' => array(
                    'type' => 'select',
                    'options' => $option['choices'],
                ),
                'options' => array(
                    'empty_option' => '-- ' . $option['name'] . ' --',
                    'label' => ''
                ),
            ));
            $this->get($name)->setValue($option['selected']);
        }
    }
}
