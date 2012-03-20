<?php

namespace CatalogManager\Controller;

use Zend\Mvc\Controller\ActionController,
    Zend\View\Model\ViewModel;

class CatalogManagerController extends ActionController
{
    protected $catalogService;
    protected $modelLinkerService;
    
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
        $class = $this->getEvent()->getRouteMatch()->getParam('class');
        $constructor = $this->getEvent()->getRouteMatch()->getParam('constructor');
        $model = $this->getCatalogService()->newModel($class, $constructor);
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
        $this->layout(false);
        $class = ($_POST['class_name'] ? $_POST['class_name'] : $_POST['new_class_name']);
        $model = $this->getModelLinkerService()->linkModel($_POST);
        return new ViewModel(array(
            $class => $model,
            'partial' => $class,
        ));
    }

    public function updateRecordAction()
    {
        $class = $this->getEvent()->getRouteMatch()->getParam('class');
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        return $this->getCatalogService()->update($class, $id, $_POST);
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

    public function getModelLinkerService()
    {
        return $this->modelLinkerService;
    }

    public function setModelLinkerService($modelLinkerService)
    {
        $this->modelLinkerService = $modelLinkerService;
        return $this;
    }
}   
