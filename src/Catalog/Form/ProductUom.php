<?php

namespace Catalog\Form;

class ProductUom extends AbstractForm
{
    protected $uomService;
    protected $originalFields = array('uom_code', 'product_id', 'quantity');

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
        $uoms = array('select' => '--SELECT--');
        foreach($this->getUomService()->getAll() as $uom){
            $uoms[$uom->getUomCode()] = $uom->getName();
        }
        $this->add(array(
            'name' => 'uom_code',
            'type' => 'Zend\Form\Element\Select',
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
