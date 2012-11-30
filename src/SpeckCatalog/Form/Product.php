<?php

namespace SpeckCatalog\Form;

class Product extends AbstractForm
{
    protected $companyService;
    protected $originalFields = array('product_id');

    public function __construct()
    {
        parent::__construct();

        $this->add(array(
            'name' => 'product_id',
            'attributes' => array(
                'type' => 'hidden'
            ),
        ));
        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Name',
            ),
        ));
        $this->add(array(
            'name' => 'description',
            'attributes' => array(
                'type' => 'textarea',
            ),
            'options' => array(
                'label' => 'Description',
            ),
        ));
        $this->add(array(
            'name' => 'item_number',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Item Number',
            ),
        ));
        $this->add(array(
            'name' => 'product_type_id',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'type' => 'select',
                'options' => array(
                    '1' => 'Shell',
                    '2' => 'Product'
                ),
            ),
            'options' => array(
                'label' => 'Product Type',
            ),
        ));
    }

    public function init()
    {
        $options = array('' => '---------');
        foreach($this->getCompanyService()->getAll() as $company){
            $options[$company->getCompanyId()] = $company->getName();
        }
        $this->add(array(
            'name' => 'manufacturer_id',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'type' => 'select',
                'options' => $options,
                'class' => 'span3',
            ),
            'options' => array(
                'label' => 'Manufacturer',
            ),
        ));
        return $this;
    }

    function getCompanyService()
    {
        return $this->companyService;
    }

    function setCompanyService($companyService)
    {
        $this->companyService = $companyService;
        return $this;
    }
}
