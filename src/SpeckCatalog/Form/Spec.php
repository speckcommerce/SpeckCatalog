<?php

namespace SpeckCatalog\Form;

class Spec extends AbstractForm
{
    protected $originalFields = ['spec_id'];

    public function __construct()
    {
        parent::__construct();
        $this->add([
            'name' => 'spec_id',
            'attributes' => [
                'type' => 'hidden'
            ],
        ]);
        $this->add([
            'name' => 'product_id',
            'attributes' => [
                'type' => 'hidden'
            ],
        ]);
        $this->add([
            'name' => 'label',
            'options' => [
                'label' => 'Label',
            ],
        ]);
        $this->add([
            'name' => 'value',
            'options' => [
                'label' => 'Value',
            ],
        ]);
    }
}
