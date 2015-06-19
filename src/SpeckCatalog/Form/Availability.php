<?php

namespace SpeckCatalog\Form;

class Availability extends AbstractForm
{
    protected $companyService;
    protected $originalFields = array('product_id', 'uom_code', 'quantity', 'distributor_id');

    public function __construct()
    {
        parent::__construct();

        $this->add(array(
            'name' => 'uom_code',
            'attributes' => array(
                'type' => 'hidden'
            ),
        ));
        $this->add(array(
            'name' => 'product_id',
            'attributes' => array(
                'type' => 'hidden'
            ),
        ));
        $this->add(array(
            'name' => 'quantity',
            'attributes' => array(
                'type' => 'hidden'
            ),
        ));
        $this->add(array(
            'name' => 'distributor_item_number',
            'attributes' => array(
                'type' => 'text',
                'class' => 'span1'
            ),
            'options' => array(
                'label' => 'Dist Item#',
            ),
        ));
        $this->add(array(
            'name' => 'distributor_uom_code',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Dist UOM',
            ),
        ));
        $this->add(array(
            'name' => 'cost',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Cost',
            ),
        ));
    }

    public function init()
    {
        $options = array('select' => '--SELECT--');
        foreach ($this->getCompanyService()->getAll() as $company) {
            $options[$company->getCompanyId()] = $company->getName();
        }
        $this->add(array(
            'name' => 'distributor_id',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'type' => 'select',
                'options' => $options,
                'class' => 'span3',
            ),
            'options' => array(
                'label' => 'Distributor',
            ),
        ));
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
