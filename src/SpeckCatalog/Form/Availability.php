<?php

namespace SpeckCatalog\Form;

class Availability extends AbstractForm
{
    protected $companyService;
    protected $originalFields = ['product_id', 'uom_code', 'quantity', 'distributor_id'];

    public function __construct()
    {
        parent::__construct();

        $this->add([
            'name' => 'uom_code',
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
            'name' => 'quantity',
            'attributes' => [
                'type' => 'hidden'
            ],
        ]);
        $this->add([
            'name' => 'distributor_item_number',
            'attributes' => [
                'type' => 'text',
                'class' => 'span1'
            ],
            'options' => [
                'label' => 'Dist Item#',
            ],
        ]);
        $this->add([
            'name' => 'distributor_uom_code',
            'attributes' => [
                'type' => 'text',
            ],
            'options' => [
                'label' => 'Dist UOM',
            ],
        ]);
        $this->add([
            'name' => 'cost',
            'attributes' => [
                'type' => 'text',
            ],
            'options' => [
                'label' => 'Cost',
            ],
        ]);
    }

    public function init()
    {
        $options = ['select' => '--SELECT--'];
        foreach ($this->getCompanyService()->getAll() as $company) {
            $options[$company->getCompanyId()] = $company->getName();
        }
        $this->add([
            'name' => 'distributor_id',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => [
                'type' => 'select',
                'options' => $options,
                'class' => 'span3',
            ],
            'options' => [
                'label' => 'Distributor',
            ],
        ]);
        return $this;
    }

    public function setCompanyService($companyService)
    {
        $this->companyService = $companyService;
        return $this;
    }

    public function getCompanyService()
    {
        return $this->companyService;
    }
}
