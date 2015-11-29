<?php

namespace SpeckCatalog\Form;

use Zend\Form\Form as ZendForm;

class AddChild extends ZendForm
{
    public function __construct()
    {
        parent::__construct();
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
}
