<?php
namespace Catalog\View\Helper;
use Zend\View\Helper\HelperInterface;
use Zend\View\Model\ViewModel;
use Zend\View\Helper\AbstractHelper;
use Zend\Form\Form as ZendForm;

class AdderHelper extends AbstractHelper
{
    public function __invoke()
    {
        return $this;
    }

    public function addNew($childName, $parentName, $parentKeyFields)
    {
        $elements = array(
            'parent_name' => $parentName,
            'child_name'  => $childName,
        );

        $form = new \Catalog\Form\AddChild;
        $form->addElements($elements)
            ->addParent($parentKeyFields);

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

        $form = new \Catalog\Form\RemoveChild;
        $form->addElements($elements)
            ->addParent($parentFormElements)
            ->addChild($childFormElements);

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
