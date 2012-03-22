<?php

namespace CatalogManager\Controller;

use Zend\Mvc\Controller\ActionController,
    Zend\View\Model\ViewModel,
    Zend\Paginator\Paginator,
    Zend\Paginator\Adapter\ArrayAdapter as ArrayAdapter;

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
        $this->redirect()->toRoute('catalogmanager/' . $class, array('id' => $model->getId()));
    }
    
    public function productsAction()
    {
        $products = $this->getCatalogService()->getAll('product');
        $paginator = new Paginator(new ArrayAdapter($products));
        $page = $this->getEvent()->getRouteMatch()->getParam('page');
        if($page){
            $paginator->setCurrentPageNumber($page);
        }
        return new ViewModel(array('products' => $paginator)); 
    }

    public function categoriesAction()
    {
        $categories = $this->getCatalogService()->getAll('category');
        $paginator = new Paginator(new ArrayAdapter($categories));
        $page = $this->getEvent()->getRouteMatch()->getParam('page');
        if($page){
            $paginator->setCurrentPageNumber($page);
        }
        return new ViewModel(array('categories' => $paginator)); 
    }

    public function categoryAction()
    {
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        $category = $this->getCatalogService()->getModel('category', $id);
        return new ViewModel(array('category' => $category));
    }

    public function searchClassAction()
    {   
        $this->layout(false);
        $class = $_POST['search_class_name'];
        $value = trim($_POST['value']);
        return new ViewModel(array(
            'results' => $this->getCatalogService()->searchClass($class, $value),
            'data'    => $_POST,
        ));
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
        $partialName = $_POST['partial_name'];
        $class = ($_POST['class_name'] ? $_POST['class_name'] : $_POST['new_class_name']);
        $model = $this->getModelLinkerService()->linkModel($_POST);
        return new ViewModel(array(
            $class => $model,
            'partial' => $_POST['partial_name'],
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
