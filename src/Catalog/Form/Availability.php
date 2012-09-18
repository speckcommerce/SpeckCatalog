<?php

namespace Catalog\Form;

use Zend\Form\Form as ZendForm;

class Availability extends ZendForm
{
    protected $companyService;

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
            'name' => 'cost',
            'attributes' => array(
                'type' => 'text',
                'class' => 'span1'
            ),
            'options' => array(
                'label' => 'Cost',
            ),
        ));
    }

    public function init()
    {
        $options = array();
        foreach($this->getCompanyService()->getAll() as $company){
            $options[$company->getCompanyId()] = $company->getName();
        }
        $this->add(array(
            'name' => 'distributor_id',
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
