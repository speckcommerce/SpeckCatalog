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

    public function __invoke($name, $views = array())
    {
        $html = '';
        foreach ($views as $view) {
            $html .= $this->renderChild($name, $view);
        }
        return $html;
    }

    public function renderChild($name, $data)
    {
        $child = new ViewModel(array($this->camel($name) => $data));
        $child->setTemplate($this->templateName($name));
        return $this->getView()->render($child);
    }

    public function templateName($name)
    {
        if ($name === 'product') {
            return 'product-clip';
        } else {
            return $this->partialDir . $this->dash($name);
        }
    }

    public function camel($name)
    {
        $camel = new \Zend\Filter\Word\UnderscoreToCamelCase;
        return lcfirst($camel->__invoke($name));
    }

    public function dash($name)
    {
        $dash = new \Zend\Filter\Word\UnderscoreToDash;
        return $dash->__invoke($name);
    }
}
