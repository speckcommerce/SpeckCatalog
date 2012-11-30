<?php
namespace SpeckCatalog\View\Helper;
use Zend\View\Helper\HelperInterface;
use Zend\View\Model\ViewModel;
use Zend\View\Helper\AbstractHelper;
use Zend\Form\Form as ZendForm;

class AdderHelper extends AbstractHelper
{
    protected $labels = array(
        'choice'       => 'Option',
        'option'       => 'Option Group',
        'availability' => 'Availability',
        'product_uom'  => 'Product Uom',
        'spec'         => 'Product Specification',
        'category'     => 'Category',
        'product'      => 'Product',
    );

    public function __invoke()
    {
        return $this;
    }

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
        $view->vars()->assign(array('addForm' => $form));

        $html = $view->render('/catalog/catalog-manager/partial/add');
        return $html;
    }


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
        $view->vars()->assign(array('removeForm' => $form));

        $html = $view->render('/catalog/catalog-manager/partial/remove');
        return $html;
    }

    private function dash($name)
    {
        $dash = new \Zend\Filter\Word\UnderscoreToDash;
        return $dash->__invoke($name);
    }
}
