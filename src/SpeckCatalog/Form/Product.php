<?php

namespace SpeckCatalog\Form;

class Product extends AbstractForm
{
    protected $companyService;
    protected $originalFields = ['product_id'];

    public function __construct()
    {
        parent::__construct();

        $this->add([
            'name' => 'product_id',
            'attributes' => [
                'type' => 'hidden'
            ],
        ]);
        $this->add([
            'name' => 'name',
            'attributes' => [
                'type' => 'text',
            ],
            'options' => [
                'label' => 'Name',
            ],
        ]);
        $this->add([
            'name' => 'description',
            'attributes' => [
                'type' => 'textarea',
            ],
            'options' => [
                'label' => 'Description',
            ],
        ]);
        $this->add([
            'name' => 'item_number',
            'attributes' => [
                'type' => 'text',
            ],
            'options' => [
                'label' => 'Item Number',
            ],
        ]);
        $this->add([
            'name' => 'product_type_id',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => [
                'type' => 'select',
                'options' => [
                    '1' => 'Shell',
                    '2' => 'Product'
                ],
            ],
            'options' => [
                'label' => 'Product Type',
            ],
        ]);
    }

    public function init()
    {
        $options = ['' => '---------'];
        foreach ($this->getCompanyService()->getAll() as $company) {
            $options[$company->getCompanyId()] = $company->getName();
        }
        $this->add([
            'name' => 'manufacturer_id',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => [
                'type' => 'select',
                'options' => $options,
                'class' => 'span3',
            ],
            'options' => [
                'label' => 'Manufacturer',
            ],
        ]);
        return $this;
    }

    public function getCompanyService()
    {
        return $this->companyService;
    }

    public function setCompanyService($companyService)
    {
        $this->companyService = $companyService;
        return $this;
    }
}
