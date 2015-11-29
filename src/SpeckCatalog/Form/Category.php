<?php

namespace SpeckCatalog\Form;

class Category extends AbstractForm
{
    protected $originalFields = ['category_id'];

    public function __construct()
    {
        parent::__construct();

        $this->add([
            'name' => 'category_id',
            'attributes' => [
                'type' => 'hidden'
            ],
        ]);
        $this->add([
            'name' => 'name',
            'attributes' => [
                'type' => 'text'
            ],
            'options' => [
                'label' => 'Name',
            ],
        ]);
    }
}
