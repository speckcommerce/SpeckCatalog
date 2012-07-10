<?php
namespace Catalog\View\Helper;
use Zend\View\Helper\HelperInterface;
use Zend\View\Model\ViewModel;
use Zend\View\Helper\AbstractHelper;

abstract class AbstractRender extends AbstractHelper
{
    protected $formService;

    protected $partialDir = "catalog/catalog-manager-redux/partial/";

    protected $name;

    protected $pluralName;

    public function __invoke($objects=null)
    {
        if(null === $objects) return '';

        $viewContainer = new ViewModel();
        $viewContainer->setTemplate($this->partialDir . $this->getPluralName() . '.phtml');

        foreach($objects as $object){
            $this->addChildView($object, $viewContainer);
        }

        $this->getView()->viewModel()->getCurrent()->addChild($viewContainer, $this->getPluralName());

        return $this->getView()->renderChildModel($this->getPluralName());
    }

    protected function addChildView($object, $parentViewContainer)
    {
        $form = $this->getFormService()->getForm($this->getName(), $object);

        $childViewContainer = new ViewModel(array( $this->getName() => $object, 'form' => $form ));
        $childViewContainer->setTemplate($this->partialDir . $this->getName() . '.phtml');
        $parentViewContainer->addChild($childViewContainer);
    }

    function getName()
    {
        return $this->name;
    }

    function getPluralName()
    {
        return $this->pluralName;
    }




 /**
  * Get serviceManager.
  *
  * @return serviceManager.
  */
 function getServiceManager()
 {
     return $this->serviceManager;
 }

 /**
  * Set serviceManager.
  *
  * @param serviceManager the value to set.
  */
 function setServiceManager(ServiceManager $serviceManager)
 {
     $this->serviceManager = $serviceManager;
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
