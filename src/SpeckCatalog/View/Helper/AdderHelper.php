<?php
namespace SpeckCatalog\View\Helper;

use Zend\Filter\Word\UnderscoreToDash as UnderscoreToDashFilter;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Helper\HelperInterface;
use Zend\View\Model\ViewModel;

class AdderHelper extends AbstractHelper
{
    /**
     * @var UnderscoreToDashFilter
     */
    protected $filter     = null;
    protected $partialDir = '';

    /**
     * labels
     *
     * @var array
     */
    protected $labels = array(
        'choice'       => 'Option',
        'option'       => 'Option Group',
        'availability' => 'Availability',
        'product_uom'  => 'Product Uom',
        'spec'         => 'Product Specification',
        'category'     => 'Category',
        'product'      => 'Product',
        'builder_product' => 'Product',
    );

    public function __invoke()
    {
        return $this;
    }

    /**
     * addNew
     *
     * @param mixed $childName
     * @param mixed $parentName
     * @param mixed $parentKeyFields
     * @return string rendered form
     */
    public function addNew($childName, $parentName, $parentKeyFields)
    {
        // if there is no parent set yet, cant show a button that wont work.
        foreach ($parentKeyFields as $key => $val) {
            if (!trim($val)) {
                return '';
            }
        }

        $elements = array(
            'parent_name' => $parentName,
            'child_name'  => $childName,
        );

        $submitButton = array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => ' + ' . $this->labels[$childName],
            ),
        );

        $form = new \SpeckCatalog\Form\AddChild;
        $form->addElements($elements)
            ->addParent($parentKeyFields);
        $form->add($submitButton);

        $view = $this->getView();
        return $view->render($this->partialDir . 'add', array('addForm' => $form));
    }

    public function find($childName, $parentName, $parentKeyFields)
    {
        $elements = array(
            'parent_name' => $parentName,
            'child_name'  => $childName,
        );

        $submitButton = array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => ' Find ' . $this->labels[$childName],
            ),
        );

        $form = new \SpeckCatalog\Form\AddChild;
        $form->addElements($elements)
            ->addParent($parentKeyFields);
        $form->add($submitButton);

        $view = $this->getView();
        return $view->render($this->partialDir . 'find', array('addForm' => $form));
    }

    /**
     * removeChild
     *
     * @param mixed $parentName
     * @param mixed $parentFormElements
     * @param mixed $childName
     * @param mixed $childFormElements
     * @return string rendered form
     */
    public function removeChild($parentName, $parentFormElements, $childName, $childFormElements)
    {
        $elements = array(
            'parent_name' => $parentName,
            'child_name'  => $childName,
        );

        $form = new \SpeckCatalog\Form\RemoveChild;
        $form->addElements($elements)
            ->addParent($parentFormElements)
            ->addChild($childFormElements);

        $removeType = 'remove-child';
        foreach ($childFormElements as $key => $val) {
            if (!trim($val)) {
                $removeType = 'remove-incomplete-child';
            }
        }
        $form->setAttribute('class', $removeType);

        $view = $this->getView();
        return $view->render($this->partialDir . 'remove', array('removeForm' => $form));
    }

    protected function dash($name)
    {
        if($this->filter == null) {
            $this->filter = new UnderscoreToDashFilter;
        }
        return $this->filter->filter($name);
    }

    /**
     * @return string partialDir
     */
    public function getPartialDir()
    {
        return $this->partialDir;
    }

    /**
     * @param string $partialDir
     * @return self
     */
    public function setPartialDir($partialDir)
    {
        $this->partialDir = $partialDir;
        return $this;
    }

    /**
     * @return array labels
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * @param array $labels
     * @return self
     */
    public function setLabels(array $labels)
    {
        $this->labels = $labels;
        return $this;
    }
}
