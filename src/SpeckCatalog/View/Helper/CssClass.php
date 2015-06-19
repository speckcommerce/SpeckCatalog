<?php



namespace SpeckCatalog\View\Helper;

use Zend\View\Helper\HelperInterface;
use Zend\View\Renderer\RendererInterface;

class CssClass implements HelperInterface
{
    protected $view;
    protected $classes = array();

    public function __invoke($param1, $param2 = false)
    {
        if (is_array($param1)) {
            return $this->init($param1, $param2);
        } elseif (is_string($param1)) {
            return $this->set($param1, $param2);
        }
        return $this;
    }

    public function init(array $classes, $returnString = false)
    {
        $this->clear();
        foreach ($classes as $class) {
            $this->set($class);
        }
        if ($returnString) {
            return $this->__toString();
        }
        return $this;
    }

    //echo out the string, and empty the classes array, so the helper can be re-used
    public function __toString()
    {
        $str = implode(' ', $this->classes);
        $this->clear();

        return $str;
    }

    public function set($k, $unset = false)
    {
        if (!$k) {
            return $this;
        }
        if ($unset) {
            unset($this->classes[$k]);
        } else {
            $this->classes[$k] = $k;
        }
        return $this;
    }

    public function clear()
    {
        $this->classes = array();
    }

    public function getView()
    {
        return $this->view;
    }

    public function setView(RendererInterface $view)
    {
        $this->view = $view;
        return $this;
    }

    public function getAttr()
    {
        return $this->attr;
    }

    public function setAttr($attr)
    {
        $this->attr = $attr;
        return $this;
    }
}
