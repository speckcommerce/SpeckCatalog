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

    public function __invoke($model)
    {
        $className = explode('\\', get_class($model));
        $modelName = lcfirst(array_pop($className));
        $name = $this->camelCaseToDashed($modelName);
        $form = $this->getFormService()->getForm($name, $model);

        $viewContainer = new ViewModel(array($modelName => $model, 'form' => $form));
        $viewContainer->setTemplate($this->partialDir . $name . '.phtml');

        return $this->getView()->render($viewContainer);
    }

    public static function camelCasetoDashed($name)
    {
        return trim(preg_replace_callback('/([A-Z])/', function($c){ return '-'.strtolower($c[1]); }, $name),'-');
    }

    /**
     * Get formService.
     *
     * @return formService.
     */
    function getFormService()
    {
        return $this->formService;
    }

    /**
     * Set formService.
     *
     * @param formService the value to set.
     */
    function setFormService($formService)
    {
        $this->formService = $formService;
    }
}
