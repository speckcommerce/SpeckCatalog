<?php
namespace Catalog\View\Helper;
use Zend\View\Helper\HelperInterface;
use Zend\View\Model\ViewModel;
use Zend\View\Helper\AbstractHelper;
use Catalog\Service\FormServiceAwareInterface;

class ChildViewRenderer extends AbstractHelper
{
    protected $partialDir = "catalog/catalog-manager/partial/";

    public function __invoke($objects=null)
    {
        if (null === $objects) {
            return;
        }
        $views = '';
        foreach($objects as $object){
            $child = new ViewModel(array( lcfirst($object->get('class_name')) => $object ));
            $child->setTemplate($this->partialDir . $object->get('dashed_class_name') . '.phtml');
            $views .= $this->getView()->render($child);
        }
        return $views;
    }
}
