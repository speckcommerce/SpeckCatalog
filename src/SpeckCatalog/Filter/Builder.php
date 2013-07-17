<?php

namespace SpeckCatalog\Filter;

use Zend\InputFilter\InputFilter;

class Builder extends Inputfilter
{
    /**
     *
     *  example data format:
     *  array(
     *      'products'   => array(
     *          'product_id' => array(
     *              'option_id' => array(
     *                  choice_id', 'choice_id'
     *              ),
     *          ),
     *      ),
     *  );
     */
    public function isValid()
    {
        $selected = $this->data['selected'];
        foreach ($selected as $optionId => $choiceId) {
            if (!is_numeric($choiceId)) {
                return false;
            }
        }

        return true;
    }

    public function getValues()
    {
        if (!$this->isValid()) {
            throw new \RuntimeException('validation failed');
        }
        return $this->data;
    }
}
