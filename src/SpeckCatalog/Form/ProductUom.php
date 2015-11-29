<?php

namespace SpeckCatalog\Form;

class ProductUom extends AbstractForm
{
    protected $uomService;
    protected $originalFields = ['uom_code', 'product_id', 'quantity'];

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
            'name' => 'quantity',
            'attributes' => [
                'type' => 'text',
                'class' => 'span1',
            ],
            'options' => [
                'label' => 'Quantity',
            ],
        ]);
        $this->add([
            'name' => 'price',
            'attributes' => [
                'type' => 'text',
                'class' => 'span1',
            ],
            'options' => [
                'label' => 'Price',
            ],
        ]);
        $this->add([
            'name' => 'retail',
            'attributes' => [
                'type' => 'text',
                'class' => 'span1',
            ],
            'options' => [
                'label' => 'Retail',
            ],
        ]);
        $this->add([
            'name' => 'enabled',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => [
                'type' => 'select',
                'options' => [1 => 'Yes', 0 => 'No'],
            ],
            'options' => [
                'label' => 'Enabled',
            ],
        ]);
    }

    public function init()
    {
        $uoms = ['select' => '--SELECT--'];
        foreach ($this->getUomService()->getAll() as $uom) {
            $uoms[$uom->getUomCode()] = $uom->getName();
        }
        $this->add([
            'name' => 'uom_code',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => [
                'type' => 'select',
                'options' => $uoms,
            ],
            'options' => [
                'label' => 'Unit of Measure',
            ],
        ]);
        return $this;
    }


    /**
     * Get uomService.
     *
     * @return uomService.
     */
    public function getUomService()
    {
        return $this->uomService;
    }

    /**
     * Set uomService.
     *
     * @param uomService the value to set.
     */
    public function setUomService($uomService)
    {
        $this->uomService = $uomService;
        return $this;
    }
}
