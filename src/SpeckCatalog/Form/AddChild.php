<?php

namespace Catalog\Form;

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
}
