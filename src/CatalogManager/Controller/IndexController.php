<?php

namespace CatalogManager\Controller;

use Zend\Mvc\Controller\ActionController,
    Zend\View\Model\ViewModel;

class IndexController extends ActionController
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

    public function indexAction()
    {
        //$this->layout();
        return new ViewModel;
    }
    
    public function productAction()
    {
        //$this->layout();
        $product = $this->getCatalogService()->getModel('product', $_GET['id']);
        
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
