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
            'name' => 'product_id',
            'attributes' => array(
                'type' => 'hidden'
            ),
        ));
        $this->add(array(
            'name' => 'quantity',
            'attributes' => array(
                'type' => 'text',
                'class' => 'span1',
            ),
            'options' => array(
                'label' => 'Quantity',
            ),
        ));
        $this->add(array(
            'name' => 'price',
            'attributes' => array(
                'type' => 'text',
                'class' => 'span1',
            ),
            'options' => array(
                'label' => 'Price',
            ),
        ));
        $this->add(array(
            'name' => 'retail',
            'attributes' => array(
                'type' => 'text',
                'class' => 'span1',
            ),
            'options' => array(
                'label' => 'Retail',
            ),
        ));
    }

    public function init()
    {
        $uoms = array();
        foreach($this->getUomService()->getAll() as $uom){
            $uoms[$uom->getName()] = $uom->getUomCode();
        }
        $this->add(array(
            'name' => 'uom_code',
            'attributes' => array(
                'type' => 'select',
                'options' => $uoms,
                'class' => 'span2',
            ),
            'options' => array(
                'label' => 'Unit of Measure',
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
