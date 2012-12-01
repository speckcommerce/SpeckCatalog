<?php
namespace SpeckCatalog\View\Helper;
use Zend\View\Helper\HelperInterface;
use Zend\View\Model\ViewModel;
use Zend\View\Helper\AbstractHelper;
use SpeckCatalog\Service\FormServiceAwareInterface;
use SpeckCatalog\Model\AbstractModel;

class Form extends AbstractHelper implements FormServiceAwareInterface
{
    protected $formService;

    protected $partialDir = "/speck-catalog/catalog-manager/partial/form/";

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
            'formErrors' => $this->renderFormMessages($this->form, false),
            'originalFields' => $this->prepareOriginalFields($this->form),
        ));
        $view->setTemplate($this->partialDir . $this->dash($this->name));
        return $this->getView()->render($view);
    }

    public function renderFormMessages($form, $showValid=true)
    {
        $html = '';

        if (!$form->isValid()) {
            $html .= '<div class="alert alert-error">';
            $html .= '<ul>';
            foreach ($form->getElements() as $element) {
                if (count($element->getMessages()) > 0) {
                    $html .= '<li>' . $element->getLabel() . ' - ' . implode(', ', $element->getMessages()) . '</li>';
                }
            }
            $html .= '</ul></div>';
        } else if($showValid) {


            $html .= '<div class="alert alert-success">';
            if ($form instanceOf \SpeckCatalog\Form\Product) {
                $html .= 'All Data is valid!  <a href="#" class="save-product">Save Now</a>';
            } else {
                $html .= 'All Data is valid!  <a href="#" class="save-now">Save Now</a>';
            }
            $html .= '</div>';
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
            throw new \Exception('form is not prepared for edit, cannot prepare original fields until edit method is called on the form');
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
