<?php

namespace SpeckCatalogManager\Controller;

use Zend\Mvc\Controller\ActionController,
    SpeckCatalogManager\Service\FormService,
    SpeckCatalogManager\Entity,
    \Exception;

class IndexController extends ActionController
{
    private $productService;
    private $productUomService;
    private $choiceService;
    private $optionService;
    private $availabilityService;
    private $userService;
    
    protected $user;
    protected $view = array();
    
    public function __construct()
    {
        if(!isset($_GET['id'])){
            $_GET['id'] = null;
        }
        $this->events()->attach('dispatch', array($this, 'preDispatch'), 100);
    }

    public function preDispatch($e)
    {
        //$this->user = $this->userService->getAuthService()->getIdentity();
        //if(!$this->user){
        //    return $this->redirect()->toRoute('zfcuser');
        //}
    }

    public function sortableSortAction(){
        echo "<script>console.log('sorted');</script>";
    }

    public function indexAction()
    {
        return $this->view;
    }

    public function productAction()
    {
        @extract($_GET);
    
        if (isset($new)) {
            $product = $this->getProductService()->newModel($new);
            $this->redirect()->toUrl('/catalogmanager/product?id='.$product->getProductId());
        } elseif (isset($id)) {
            return array('product' => $this->getProductService()->getById($id));
        }
    }

    private function prepPaginator($name, $items=null, $perPage=10, $pageNum=1)
    {
        if(is_array($items)){ 
           $this->view["{$name}Paginator"] = \Zend\Paginator\Paginator::factory($items)
               ->setItemCountPerPage($perPage)->setCurrentPageNumber($pageNum); 
        }
    }

    public function updateRecordAction()
    {
        $modelService = $_GET['className'].'Service';
        $return = $this->$modelService->updateModelFromArray($_POST);
        die($return->__toString());
    }

    public function removeAction()
    {
        @extract($_POST);
        $modelService = $model.'Service';

        if ('delete' === $action){
            var_dump($this->$modelService->delete($id));
        } elseif ('unlink' === $action){
            var_dump($this->$modelService->unlink($id, $parentId));
        }
        die();
    }

    public function searchClassesAction()
    {
        @extract($_POST);
        $products = $this->productService->getModelsBySearchData($value);
        if($products){
            foreach($products as $product){
                $this->view['results'][] = $product;
            }
        }
        $options = $this->optionService->getModelsBySearchData($value);
        if($options){
            foreach($options as $option){
                $this->view['results'][] = $option;
            }
        }
        
        $this->view['nolayout'] = true;
        return $this->view;
    }

    public function searchClassAction()
    {   
        @extract($_POST);
        $modelService = $className.'Service';

        $this->view['nolayout'] = true;
        $this->view['results']  = $this->$modelService->getModelsBySearchData($value);
        $this->view['parentId'] = $parentId;
        $this->view['parentClassName'] = $parentClassName;
        return $this->view;
    }

    public function camelCaseToDashed($name)
    {
        return trim(preg_replace_callback('/([A-Z])/', function($c){ return '-'.strtolower($c[1]); }, $name),'-');
    }

    protected function fetchPartialAction()
    {
        @extract($_POST);
        $modelService = $className.'Service';
        if(isset($isNew)){
            $newClass = 'new'.ucfirst($parentClassName).ucfirst($className);
            $this->view[$className] = $this->$modelService->$newClass($parentId);
        }else{
            if($parentId && $parentClassName){
                $linkParentClass = 'linkParent'.ucfirst($parentClassName);
                $this->$modelService->$linkParentClass($parentId, $entityId);  
            }
            $this->view[$className] = $this->$modelService->getById($_POST['entityId']);
        }
        
        $this->view['partial'] = $this->camelCaseToDashed($className);
        $this->view['nolayout'] = true;
        return $this->view;
    }

    public function entityOptionsAjaxAction()
    {
        $this->view['nolayout'] = true;
        $this->view['options'] = array('save');
        return $this->view;
    }

    public function getProductService()
    {
        return $this->productService;
    }

    public function setProductService($productService)
    {
        $this->productService = $productService->setUser($this->user);
        return $this;
    }
 
    public function getOptionService()
    {
        return $this->optionService;
    }

    public function setOptionService($optionService)
    {
        $this->optionService = $optionService->setUser($this->user);
        return $this;
    }
 
    public function getChoiceService()
    {
        return $this->choiceService;
    }

    public function setChoiceService($choiceService)
    {
        $this->choiceService = $choiceService->setUser($this->user);
        return $this;
    }

    public function getProductUomService()
    {
        return $this->productUomService;
    }

    public function setProductUomService($productUomService)
    {
        $this->productUomService = $productUomService->setUser($this->user);
        return $this;
    }

    public function getAvailabilityService()
    {
        return $this->availabilityService;
    }

    public function setAvailabilityService($availabilityService)
    {
        $this->availabilityService = $availabilityService->setUser($this->user);
        return $this;
    }
    
    public function setUserService($userService)
    {
        $this->userService = $userService;
    }

    public function setSessionService($catalogManagerService)
    {                                              
        $this->sessionService = $catalogManagerService;
    }
}                                   
