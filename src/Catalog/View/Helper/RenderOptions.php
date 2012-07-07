<?php
namespace Catalog\View\Helper;
use Zend\View\Helper\HelperInterface;
use Zend\View\Model\ViewModel;
use Zend\View\Helper\AbstractHelper;
class RenderOptions extends AbstractHelper
{
    protected $partialDir = "catalog/catalog-manager-redux/partial/";

    public function __invoke($options=null)
    {
        if(null === $options){
            return;
        }
        $model = $this->getView()->viewModel()->getCurrent();
        $this->renderOptionsView($options, $model);
        return $this->getView()->renderChildModel($model->captureTo());
    }

    protected function renderOptionsView($options, $parentView)
    {
        $view = new ViewModel();
        $view->setTemplate($this->partialDir . 'options.phtml');
        foreach($options as $option){
            $this->childViewSegment('option', $option, $view);
            if($option->has('choices')){
                $this->renderChoicesView($option->getChoices(), $view);
            }
        }
        return $parentView->addChild($view, 'content');
    }

    protected function renderChoicesView($choices, $parentView)
    {
        $view = new ViewModel();
        $view->setTemplate($this->partialDir . 'choices.phtml');
        foreach($choices as $choice){
            $this->childViewSegment('choice', $choice, $view);
            if($choice->has('options')){
                $this->renderOptionsView($choice->getOptions(), $view);
            }
        }
        $parentView->addChild($view, 'choices');
    }

    protected function childViewSegment($name, $model, $parentView)
    {
        $view = new ViewModel(array( $name => $model ));
        $view->setTemplate($this->partialDir . $name . '.phtml');
        $parentView->addChild($view);
    }
}
