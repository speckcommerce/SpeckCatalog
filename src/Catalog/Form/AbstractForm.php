<?php

namespace Catalog\Form;

use Zend\Form\Form as ZendForm;
use Zend\Form\FormInterface;
use Zend\Stdlib\Hydrator\ClassMethods as Hydrator;

class AbstractForm extends ZendForm
{
    /*
     * flag is set to false if edit() has been called,
     * to differentiate between a form for a new record, or an existing record.
     */
    protected $new=true;

    /*
     * automatically set the hydrator for the form
     */
    public function __construct()
    {
        parent::__construct();
        $this->setHydrator(new Hydrator);
    }

    public function prepare()
    {
        parent::prepare();
        return $this;
    }

    /*
     * adds extra form elements, used to generate the where statement
     * when updating the record.
     */
    public function edit()
    {
        $this->new = false;
        $elements = $this->getElements();
        foreach ($this->getOriginalFields() as $field) {
            $this->add(array(
                'name' => 'original_' . $field,
                'attributes' => array(
                    'type' => 'hidden',
                    'value' => $elements[$field]->getValue(),
                )
            ));
            //$this->getFilter()->add(array(
            //    'name' => 'original_' . $field,
            //    'required' => true,
            //));
        }
        return $this;
    }

    public function isNew()
    {
        return $this->new;
    }

    /*
     * returns the data without any of the extra fields
     * that may have been added when edit() was called
     */
    public function getData($flag = FormInterface::VALUES_NORMALIZED)
    {
        $data = parent::getData($flag);
        if (false === $this->isNew()) {
            foreach ($this->getOriginalFields() as $field) {
                $key = 'original_' . $field;
                if(array_key_exists($key, $data)) {
                    unset($data[$key]);
                }
            }
        }
        return $data;
    }

    /*
     * returns array of fields and values before the form data was modified
     * so a where statement can be built to update a the record in the database
     */
    public function getOriginalData()
    {
        $data = $this->data;
        $originals = array();
        foreach($this->getOriginalFields() as $field) {
            $key = 'original_' . $field;
            if(array_key_exists($key, $data)) {
                $originals[$field] = $data[$key];
            }
        }
        return $originals;
    }

    private function camel($name)
    {
        $camel = new \Zend\Filter\Word\UnderscoreToCamelCase;
        return $camel->__invoke($name);
    }

    /**
     * @return originalFields
     */
    public function getOriginalFields()
    {
        return $this->originalFields;
    }

    /**
     * @param $originalFields
     * @return self
     */
    public function setOriginalFields($originalFields)
    {
        $this->originalFields = $originalFields;
        return $this;
    }
}
