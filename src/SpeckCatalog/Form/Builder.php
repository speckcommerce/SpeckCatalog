<?php

namespace SpeckCatalog\Form;

use SpeckCatalog\Model\Builder\Relational as Model;

class Builder extends AbstractForm
{
    protected $originalFields = array();

    public function __construct($options = array())
    {
        parent::__construct();

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'parent_product_id',
            'attributes' => array(
                'type' => 'hidden',
            ),
            'options' => array(
                'label' => '',
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'product_id',
            'attributes' => array(
                'type' => 'hidden',
            ),
            'options' => array(
                'label' => '',
            ),
        ));
    }

    public function setObject($object)
    {
        if ($object->has('options')) {
            foreach($object->getOptions() as $option) {
                $optionId = $option->getOptionId();
                $optionName = $option->getName();

                $choices = array();
                foreach ($option->getChoices() as $choice) {
                    $choices[$choice->getChoiceId()] = $choice->__toString();
                }

                $selectedChoiceId = isset($object->getSelected()[$optionId]) ? (int) $object->getSelected()[$optionId] : null;
                $data = array(
                    'option_id' => $option->getOptionId(),
                    'name'      => $option->getName(),
                    'selected'  => $selectedChoiceId,
                    'choices'   => $choices
                );
                $this->addOption($data);
            }
        }
        return parent::setObject($object);
    }

    public function addOption(array $option)
    {
        $name = "selected[{$option['option_id']}]";
        $this->add(array(
            'name' => $name,
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'type' => 'select',
                'options' => $option['choices'],
            ),
            'options' => array(
                'empty_option' => '-- Option: "' . $option['name'] .  '" Choice: --',
                'label' => ""
            ),
        ));
        if (is_int($option['selected'])) {
            $this->get($name)->setValue($option['selected']);
        }
    }

    public function addOptions($options)
    {
        $productId = $this->data['product_id'];
        foreach ($options as $optionId => $option) {
            $this->data['products'][$productId][$optionId] = $option['selected'];
            $name =  'products['.$productId.']['.$optionId.']';
            $this->add(array(
                'name' => $name,
                'type' => 'Zend\Form\Element\Select',
                'attributes' => array(
                    'type' => 'select',
                    'options' => $option['choices'],
                ),
                'options' => array(
                    'empty_option' => '-- ' . $option['name'] . ' --',
                    'label' => ''
                ),
            ));
            $this->get($name)->setValue($option['selected']);
        }
    }
}
