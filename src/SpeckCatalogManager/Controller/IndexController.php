<?php

namespace SpeckCatalogManager\Controller;

use Zend\Mvc\Controller\ActionController,
    SpeckCatalogManager\Service\FormService,
    SpeckCatalogManager\Entity,
    \Exception;

class IndexController extends ActionController
{
    protected $productService;
    
    protected $userService;
    protected $sessionService;
    protected $view = array();
    
    public function __construct()
    {
        if(!isset($_GET['constructor'])){
            $_GET['constructor'] = null;
        }
        if(!isset($_GET['entityId'])){
            $_GET['entityId'] = null;
        }
        $this->events()->attach('dispatch', array($this, 'preDispatch'), 100);
    }

    public function preDispatch($e)
    {
        $user = $this->userService->getAuthService()->getIdentity();
        if(!$user){
            return $this->redirect()->toRoute('zfcuser');
        }
        
        //$this->session = $this->sessionService->getSession($user);
        //$this->formService = new FormService(); 
        //$this->view['session'] = $this->session;
    }
    public function sortableSortAction(){
        echo "<script>console.log('sorted');</script>";
    }

    public function indexAction()
    {
        
        return $this->view;
    }
    
    private function getEntity($className, $entityId=null, $constructor=null, $notifyNew=false)
    {
        if($entityId){
            $session = $this->sessionService->getSession();
            if(is_numeric($entityId)){
                return $session[$className.'-'.$entityId];
            }else{
                return $session[$entityId];
            }
        }else{
            if($notifyNew === false){
                $this->view['messages'][] = array(
                    'type' => 'success',
                    'status' => 'If you insist!', 
                    'message' => "You have just added a new {$className} ({$constructor}) to your session.",
                );
            }
            $class = '\SpeckCatalog\Model\\'.$className;
            $entity = new $class($constructor);
            return $entity;
        } 
    }

    public function productAction()
    {
        $this->view['product'] = $this->productService->getProductById($_GET['id']);
        return $this->view;
    }

    private function prepPaginator($name, $items=null, $perPage=10, $pageNum=1)
    {
        if(is_array($items)){ 
           $this->view["{$name}Paginator"] = \Zend\Paginator\Paginator::factory($items)
               ->setItemCountPerPage($perPage)->setCurrentPageNumber($pageNum); 
        }
    }

    public function setUserService($userService)
    {
        $this->userService = $userService;
    }

    public function setSessionService($catalogManagerService)
    {                                              
        $this->sessionService = $catalogManagerService;
    }

    protected function entitySearchAction()
    {
        $this->view['nolayout'] = true;
        $this->view['results'] = $this->sessionService->getSession();
        return $this->view;
    }   

    protected function livePartialAction()
    {
        $this->view['nolayout'] = true;
        $className = $_GET['className'];
        $entityId = $_GET['entityId'];
        $this->view['partial'] = $className;
        $entity = $this->getEntity($className, $entityId);
        $this->view[$className] = $entity;
        return $this->view;
    }
    public function entityOptionsAjaxAction()
    {
        $this->view['nolayout'] = true;
        $this->view['options'] = array('save',);
        return $this->view;
    }

 

    public function getProductService()
    {
        return $this->productService;
    }

    public function setProductService($productService)
    {
        $this->productService = $productService;
        return $this;
    }
}                                   
