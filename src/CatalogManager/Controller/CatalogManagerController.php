<?php

namespace CatalogManager\Controller;

use Zend\Mvc\Controller\ActionController,
    Zend\View\Model\ViewModel;

class CatalogManagerController extends ActionController
{
    protected $catalogService;
    
    public function layout($layout=null)
    {
        if(null === $layout){
            $this->getEvent()->getViewModel()->setTemplate('layout/catalogmanager');
        }elseif(false === $layout){
            $this->getEvent()->getViewModel()->setTemplate('layout/nolayout');
        }else{
            $this->getEvent()->getViewModel()->setTemplate('layout/' . $layout);
        }
    }

    public function optionSliderTestAction()
    {
        $slider = new \Catalog\Model\OptionSlider;
        $slider->setStart(1)
               ->setEnd(25)
               ->setIncriment(.5);
        var_dump($slider->__toArray());
        die();
    }

    public function indexAction()
    {
        $products = $this->getCatalogService()->getAll('product');
        return new ViewModel(array('products' => $products));
    }

    public function newAction()
    {
        $something = $this->getEvent()->getRouteMatch()->getParam('something');
        $constructor = $this->getEvent()->getRouteMatch()->getParam('constructor');
        $model = $this->getCatalogService()->newModel($something, $constructor);
        $this->redirect()->toRoute('catalogmanager/product', array('id' => $model->getId()));
    }

    
    public function productAction()
    {
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        $product = $this->getCatalogService()->getModel('product', $id);
        
        return new ViewModel(array('product' => $product));
    }
    
    public function fetchPartialAction()
    {
        return new ViewModel(array($_POST['class'] =>$this->getModelLinkerService->getModel($_POST)));
    }

    public function remove()
    {
        die($this->getModelLinkerService->remove($_POST));
    }
    
    public function getCatalogService()
    {
        return $this->catalogService;
    }
 
    public function setCatalogService($catalogService)
    {
        $this->catalogService = $catalogService;
        return $this;
    }
}   
