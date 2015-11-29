<?php

namespace SpeckCatalog\Form;

use Zend\Form\Form as ZendForm;

class RemoveChild extends ZendForm
{
    public function __construct()
    {
        parent::__construct();
        $this->add([
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => [
                'value' => ' x ',
            ],
        ]);
    }

    public function addElements(array $elements)
    {
        foreach ($elements as $key => $val) {
            $this->add([
                'name' => $key,
                'attributes' => [
                    'type' => 'hidden',
                    'value' => $val,
                ],
            ]);
        }
        return $this;
    }

    public function addParent(array $elements)
    {
        foreach ($elements as $key => $val) {
            $this->add([
                'name' => 'parent[' . $key . ']',
                'attributes' => [
                    'type' => 'hidden',
                    'value' => $val,
                ],
            ]);
        }
        return $this;
    }

    public function addChild(array $elements)
    {
        foreach ($elements as $key => $val) {
            $this->add([
                'name' => 'child[' . $key . ']',
                'attributes' => [
                    'type' => 'hidden',
                    'value' => $val,
                ],
            ]);
        }
        return $this;
    }
}
