<?php
namespace SpeckCatalog\View\Helper;
use Zend\View\Helper\HelperInterface;
use Zend\View\Model\ViewModel;
use Zend\View\Helper\AbstractHelper;
use SpeckCatalog\Service\FormServiceAwareInterface;

/*
 * loops through an array of model objects and renders the view for each
 */
class ChildViewRenderer extends AbstractHelper
{
    // @todo replace with option
    protected $partialDir = '/speck-catalog/catalog-manager/partial/';

    public function __invoke($name=null, $objects=null)
    {
        if(!$name) {
            throw new \Exception('need a name');
        }
        if (null === $objects) {
            return;
        }
        $views = '';
        foreach ($objects as $object) {
            $child = new ViewModel(array($this->camel($name) => $object));
            $child->setTemplate($this->partialDir . $this->templateName($name) . '.phtml');
            $views .= $this->getView()->render($child);
        }
        return $views;
    }

    private function templateName($name)
    {
        if ($name === 'product') {
            return 'product-clip';
        } else {
            return $this->dash($name);
        }
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
}
