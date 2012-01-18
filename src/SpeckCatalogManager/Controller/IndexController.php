<?php

namespace SpeckCatalogManager\Controller;

use Zend\Mvc\Controller\ActionController,
    SpeckCatalogManager\Service\FormService,
    SpeckCatalogManager\Entity,
    \Exception;

class IndexController extends ActionController
{
    protected $productService;
    protected $productUomService;
    protected $choiceService;
    protected $optionService;

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
    }

    public function sortableSortAction(){
        echo "<script>console.log('sorted');</script>";
    }

    public function indexAction()
    {
        return $this->view;
    }
    
    public function updateRecordAction()
    {
        $modelService = $_GET['className'].'Service';
        $return = $this->$modelService->updateModelFromArray($_POST);
        
        var_dump($return);
        die();
    }

    public function productAction()
    {
        if(isset($_GET['new'])){
            $this->view['product'] = $this->productService->newModel($_GET['new']);
        }else{
            $this->view['product'] = $this->productService->getModelById($_GET['id']);
        }
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

    public function entitySearchAction()
    {
        @extract($_POST);
        $this->view['nolayout'] = true;
        $modelService = $className.'Service';
        $this->view['results'] = $this->$modelService->getModelsBySearchData($value);
        $this->view['parentId'] = $parentId;
        return $this->view;
    }   
    
    public function camelCaseToDashed($name)
    {
        return trim(preg_replace_callback('/([A-Z])/', function($c){ return '-'.strtolower($c[1]); }, $name),'-');
    }

    protected function fetchPartialAction()
    {
        $this->view['nolayout'] = true;
        @extract($_POST);
        $modelService = $className.'Service';
        if(isset($isNew)){
            $newClass = 'new'.ucfirst($parentClassName).ucfirst($className);
            $this->view[$className] = $this->$modelService->$newClass($parentId);
        }else{
            if($parentId){
                $this->$modelService->linkParent($parentId, $entityId);  
            }
            $this->view[$className] = $this->$modelService->getModelById($_POST['entityId']);
        }
        $this->view['partial'] = $this->camelCaseToDashed($className);
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
 
    public function getOptionService()
    {
        return $this->optionService;
    }

    public function setOptionService($optionService)
    {
        $this->optionService = $optionService;
        return $this;
    }
 
    public function getChoiceService()
    {
        return $this->choiceService;
    }

    public function setChoiceService($choiceService)
    {
        $this->choiceService = $choiceService;
        return $this;
    }

    public function getProductUomService()
    {
        return $this->productUomService;
    }

    public function setProductUomService($productUomService)
    {
        $this->productUomService = $productUomService;
        return $this;
    }
}                                   
