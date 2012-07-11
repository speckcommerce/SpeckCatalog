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
        $form = $this->getFormService()->getForm($model->get('dashed_class_name'), $model);

        $viewContainer = new ViewModel(array(lcfirst($model->get('class_name')) => $model, 'form' => $form));
        $viewContainer->setTemplate($this->partialDir . $model->get('dashed_class_name') . '.phtml');

        return $this->getView()->render($viewContainer);
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
