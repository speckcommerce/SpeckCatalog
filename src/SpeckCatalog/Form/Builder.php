<?php

namespace SpeckCatalog\Form;

use SpeckCatalog\Model\Builder\Relational as Model;
use Zend\Form\FormInterface;

class Builder extends AbstractForm
{
    protected $originalFields = [];

    public function __construct($options = [])
    {
        parent::__construct();

        $this->add([
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'parent_product_id',
            'attributes' => [
                'type' => 'hidden',
            ],
            'options' => [
                'label' => '',
            ],
        ]);
        $this->add([
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'product_id',
            'attributes' => [
                'type' => 'hidden',
            ],
            'options' => [
                'label' => '',
            ],
        ]);
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
        $this->add([
            'name' => $name,
            'type' => 'Zend\Form\Element\Select',
            'attributes' => [
                'type' => 'select',
                'options' => $option['choices'],
            ],
            'options' => [
                'empty_option' => "\"{$option['name']}\" (Select)",
                'label' => ""
            ],
        ]);
        if (is_int($option['selected'])) {
            $this->get($name)->setValue($option['selected']);
        }
    }

    public function addOptions($object)
    {
        foreach ($object->getOptions() as $option) {
            $optionId = $option->getOptionId();
            $optionName = $option->getName();

            $choices = [];
            foreach ($option->getChoices() as $choice) {
                $choices[$choice->getChoiceId()] = $choice->__toString();
            }

            $selectedChoiceId = isset($object->getSelected()[$optionId])
                ? (int) $object->getSelected()[$optionId]
                : null;
            $data = [
                'option_id' => $option->getOptionId(),
                'name'      => $option->getName(),
                'selected'  => $selectedChoiceId,
                'choices'   => $choices
            ];
            $this->addOption($data);
        }
    }
}
