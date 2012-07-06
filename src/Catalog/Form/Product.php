<?php

namespace Catalog\Form;

use Zend\Form\Form as ZendForm;

class Product extends ZendForm
{
    protected $companyService;

    public function __construct()
    {
        parent::__construct();

        $this->add(array(
            'name' => 'recordId',
            'attributes' => array(
                'label' => 'Record Id',
                'type' => 'hidden'
            ),
        ));
        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'label' => 'Name',
                'type' => 'text',
                'class' => 'span6',
            ),
        ));
        $this->add(array(
            'name' => 'description',
            'attributes' => array(
                'label' => 'Description',
                'type' => 'textarea',
                'rows' => 5,
                'class' => 'span6',
            ),
        ));
        $this->add(array(
            'name' => 'itemNumber',
            'attributes' => array(
                'label' => 'Item Number',
                'type' => 'text',
                'class' => 'span3',
            ),
        ));
    }

    public function init()
    {
        $options = array();
        foreach($this->getCompanyService()->getAll() as $company){
            $options[$company->getName()] = $company->getRecordId();
        }
        $this->add(array(
            'name' => 'manufacturerCompanyId',
            'attributes' => array(
                'label' => 'Manufacturer',
                'type' => 'select',
                'options' => $options,
                'class' => 'span3',
            ),
        ));
        return $this;
    }

    /**
     * Get companyService.
     *
     * @return companyService.
     */
    function getCompanyService()
    {
        return $this->companyService;
    }

    /**
     * Set companyService.
     *
     * @param companyService the value to set.
     */
    function setCompanyService($companyService)
    {
        $this->companyService = $companyService;
        return $this;
    }
}
