<?php

namespace SpeckCatalog\Form;

class Choice extends AbstractForm
{
    protected $originalFields = ['choice_id'];

    public function __construct()
    {
        parent::__construct();

        $this->add([
            'name' => 'option_id',
            'attributes' => [
                'type' => 'hidden'
            ],
        ]);
        $this->add([
            'name' => 'choice_id',
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
            'name' => 'override_name',
            'attributes' => [
                'type' => 'text'
            ],
            'options' => [
                'label' => 'Name',
            ],
        ]);
    }
}
