<?php
namespace Catalog\View\Helper;
use Zend\View\Helper\HelperInterface;
use Zend\View\Model\ViewModel;
use Zend\View\Helper\AbstractHelper;
use Catalog\Service\FormServiceAwareInterface;

class RenderForm extends AbstractHelper implements FormServiceAwareInterface
{
    protected $formService;

    protected $partialDir = "catalog/catalog-manager/partial/form/";

    public function __invoke($model=null, $name=null)
    {
        if(!isset($model) || !isset($name)){
            throw new \Exception('');
        }

        $form = $this->getFormService()->getForm($name, $model);
        $view = new ViewModel(array($this->camel($name) => $model, 'form' => $form));
        $view->setTemplate($this->partialDir . $this->dash($name) . '.phtml');

        return $this->getView()->render($view);
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
    }
}
