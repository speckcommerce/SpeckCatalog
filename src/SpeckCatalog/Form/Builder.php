<?php

namespace SpeckCatalog\Form;

use SpeckCatalog\Model\Builder\Relational as Model;
use Zend\Form\FormInterface;

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

    public function bind($object, $flags = FormInterface::VALUES_NORMALIZED)
    {
        if ($object->has('options')) {
            $this->addOptions($object);
        }
        return parent::setObject($object, $flags);
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
                'empty_option' => "\"{$option['name']}\" (Select)",
                'label' => ""
            ),
        ));
        if (is_int($option['selected'])) {
            $this->get($name)->setValue($option['selected']);
        }
    }

    public function addOptions($object)
    {
        foreach ($object->getOptions() as $option) {
            $optionId = $option->getOptionId();
            $optionName = $option->getName();

            $choices = array();
            foreach ($option->getChoices() as $choice) {
                $choices[$choice->getChoiceId()] = $choice->__toString();
            }

            $selectedChoiceId = isset($object->getSelected()[$optionId])
                ? (int) $object->getSelected()[$optionId]
                : null;
            $data = array(
                'option_id' => $option->getOptionId(),
                'name'      => $option->getName(),
                'selected'  => $selectedChoiceId,
                'choices'   => $choices
            );
            $this->addOption($data);
        }
    }
}
