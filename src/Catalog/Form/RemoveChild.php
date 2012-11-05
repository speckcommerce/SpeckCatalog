<?php

namespace Catalog\Form;

use Zend\Form\Form as ZendForm;

class RemoveChild extends ZendForm
{
    public function __construct()
    {
        parent::__construct();
        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => ' x ',
            ),
        ));
    }

    public function addElements(array $elements)
    {
        foreach ($elements as $key => $val) {
            $this->add(array(
                'name' => $key,
                'attributes' => array(
                    'type' => 'hidden',
                    'value' => $val,
                ),
            ));
        }
        return $this;
    }

    public function addParent(array $elements)
    {
        foreach ($elements as $key => $val) {
            $this->add(array(
                'name' => 'parent[' . $key . ']',
                'attributes' => array(
                    'type' => 'hidden',
                    'value' => $val,
                ),
            ));
        }
        return $this;
    }

    public function addChild(array $elements)
    {
        foreach ($elements as $key => $val) {
            $this->add(array(
                'name' => 'child[' . $key . ']',
                'attributes' => array(
                    'type' => 'hidden',
                    'value' => $val,
                ),
            ));
        }
        return $this;
    }
}
