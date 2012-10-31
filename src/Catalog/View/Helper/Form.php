<?php
namespace Catalog\View\Helper;
use Zend\View\Helper\HelperInterface;
use Zend\View\Model\ViewModel;
use Zend\View\Helper\AbstractHelper;
use Catalog\Service\FormServiceAwareInterface;
use Catalog\Model\AbstractModel;

class Form extends AbstractHelper implements FormServiceAwareInterface
{
    protected $formService;

    protected $partialDir = "catalog/catalog-manager/partial/form/";

    protected $form;

    protected $name;

    protected $model;

    public function __invoke(AbstractModel $model=null, $name=null)
    {
        $this->model = $model;
        $this->name = $name;
        $this->form = $this->getFormService()->getForm($name, $model);

        return $this;
    }

    public function renderform()
    {
        $this->form
            ->edit()
            ->prepare()
            ->setAttribute('id', $this->name)
            ->setAttribute('class', 'live-form');

        $view = new ViewModel(array(
            $this->camel($this->name) => $this->model,
            'form' => $this->form,
            'formErrors' => $this->renderFormErrors($this->form),
            'originalFields' => $this->prepareOriginalFields($this->form),
        ));
        $view->setTemplate($this->partialDir . $this->dash($this->name) . '.phtml');
        return $this->getView()->render($view);
    }

    public function renderFormErrors($form)
    {
        $html = '';

        if (!$form->isValid()) {
            $html .= '<div class="alert alert-error">';
            $html .= '<strong> Check the fields listed below</strong>';
            $html .= '<ul>';
            foreach ($form->getElements() as $element) {
                if (count($element->getMessages()) > 0) {
                    //$html .= '<li>' . $element->getLabel() . '</li>'; //using lines below for debugging
                    $name = trim($element->getLabel()) ? $element->getLabel() : 'hidden field: ' . $element->getName();
                    $html .= '<li>' . $name . '</li>';
                }
            }
            $html .= '</ul></div>';
        }

        return $html;
    }

    public function getKeyFields()
    {
        return $this->getFormService()->getKeyFields($this->name, $this->model);
    }

    public function prepareOriginalFields($form)
    {
        $html = '';
        if (!$form->isNew()) {
            foreach ($form->getOriginalFields() as $field) {
                $element = $form->get('original_' . $field);
                $html .= '<input type="hidden" name = "' . $element->getName() . '" value="' . $element->getValue() . '" />';
            }
        } else {
            throw new \Exception('form is still "new", try $form->edit() first');
        }
        return $html;
    }

    private function camel($name)
    {
        $camel = new \Zend\Filter\Word\UnderscoreToCamelCase;
        return lcfirst($camel->__invoke($name));
    }

    private function dash($name)
    {
        $dash = new \Zend\Filter\Word\UnderscoreToDash;
        return $dash->__invoke($name);
    }

    function getFormService()
    {
        return $this->formService;
    }

    function setFormService($formService)
    {
        $this->formService = $formService;
        return $this;
    }
}
