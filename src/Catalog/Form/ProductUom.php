<?php

namespace Catalog\Form;

use Zend\Form\Form as ZendForm;

class ProductUom extends ZendForm
{
    protected $uomService;

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
    }

    public function init()
    {
        $options = array();
        foreach($this->getUomService()->getAll() as $uom){
            $options[$company->getRecordId()] = $uom->getRecordId();
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
  * Get uomService.
  *
  * @return uomService.
  */
 function getUomService()
 {
     return $this->uomService;
 }

 /**
  * Set uomService.
  *
  * @param uomService the value to set.
  */
 function setUomService($uomService)
 {
     $this->uomService = $uomService;
     return $this;
 }
}
