<?php

namespace SpeckCatalogManager\Controller;

use Zend\Mvc\Controller\ActionController,
    \Exception;

class IndexController extends ActionController
{
    protected $userService;
    protected $catalogService;
    protected $item;
    protected $product;
    protected $option;
    protected $choice;
    protected $company;
    protected $productUom;
    protected $uom;
    protected $availability;
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
            return $this->redirect()->toRoute('edpuser');
        }
        $this->session = $this->sessionService->getSession($user);
        $this->view['messages'] = array();
        $this->view['session'] = $this->session;
    }
    
    public function indexAction()
    {
        $this->view['sessionPaginator'] = $this->paginate(null, $this->session->getEntities(), 2);
        return $this->view;
    }
    
    private function paginate($pageNum=1, $items=null, $perPage=10)
    {
        $paginator = \Zend\Paginator\Paginator::factory($items)->setItemCountPerPage($perPage)->setCurrentPageNumber($pageNum);
        return $paginator;
    }
    
    private function getEntity($className, $constructor=null, $entityId)
    {
        if(isset($entityId)){
            $entity = $this->session->getEntityById($entityId);
            if($entity){
                return $entity;
            }else{
                die('couldnt find an entity with that id');
            }
        }else{
            $this->view['messages'][] = array(
                'type' => 'success',
                'status' => 'Grow your session 2 inches now!', 
                'message' => "You have just added a new {$className} ({$constructor}) to your session.",
            );
            $class = '\SpeckCatalogManager\Entity\\'.$className;
            try {
                return new $class($constructor);
            } catch (Exception $e) {
                die('heres your error - '.$e);
            }
            
        } 
    }

    private function getFormManager($entity)
    {
        $class = get_class($entity);
        $classArr = explode('\\', $class);
        $className = array_pop($classArr);  

        $definitionClass = 'SpeckCatalog\Form\Definition\\'.$className;

        return $this->getLocator()->get(
            'spiffy_form', 
            array('definition' => $definitionClass, 'data' => $entity,)
        )->build();
    }

    public function productAction()
    {
        $entity = $this->getEntity('Product', $_GET['constructor'], $_GET['entityId']);
        
        $options = $entity->getOptions();
        if($options){
            $this->view['optionPaginator'] = $this->paginate(null, $options, null);
        }
        if($entity->getItem()){
            $item = $entity->getItem();
            if($item){
                if($item->getUoms() > 0){
                    $this->view['itemProductUomPaginator'] = $this->paginate(null, $item->getUoms(), null);
                }
            }
            $manufacturer = $item->getManufacturer();
            if($manufacturer){
                $this->view['itemManufacturerPaginator'] = $this->paginate(null, array($manufacturer), null);
            }

        }
        
        $parentChoices = $entity->getParentChoices();
        if($parentChoices){
            $this->view['parentChoicesPaginator'] = $this->paginate(null, $parentChoices, null);
        }
        
        $formManager = $this->getFormManager($entity);

        $this->view['paginator'] = $this->paginate(null, $this->session->getEntities(), 2);
        $this->view['product'] = $entity;
        $this->view['form'] = $formManager->getForm();
        return $this->view;  
    }
    public function optionAction()
    {
        if(!$this->option)$this->option = new \Management\Entity\Option('radio');
        return array(
            'session' => $this->session,
            'option'  => $this->getEntity('Option', $_GET['constructor'], $_GET['entityId']),
            'entity'  => $this->getEntity('Option', $_GET['constructor'], $_GET['entityId']),
        ); 
    }
    public function choiceAction()
    {
        $entity = $this->getEntity('Choice', $_GET['constructor'], $_GET['entityId']);
        
        $product = $entity->getProduct();
        if($product){
            $this->view['productPaginator'] = $this->paginate(null, $product, null);
        }
        
        $parentChoices = $entity->getParentChoices();
        if($parentChoices){
            $this->view['parentChoicesPaginator'] = $this->paginate(null, $parentChoices, null);
        }
        
        $formManager = $this->getFormManager($entity);

        $this->view['paginator'] = $this->paginate(null, $this->session->getEntities(), 2);
        $this->view['product'] = $entity;
        $this->view['form'] = $formManager->getForm();
        return $this->view;  
    }
    public function companyAction()
    {
        if(!$this->company)$this->company = new \Management\Entity\Company;
        return array(
            'session' => $this->session,
            'company' => $this->getEntity('Company', null, $_GET['entityId']),
            'entity'  => $this->getEntity('Company', null, $_GET['entityId']),
        ); 
    }
    public function productUomAction()
    {
        if(!$this->productUom)$this->productUom = new \Management\Entity\ProductUom;
        return array(
            'session' => $this->session,
            'productUom' => $this->getEntity('ProductUom', null, $_GET['entityId']),
            'entity'  => $this->getEntity('ProductUom', null, $_GET['entityId']),
        ); 
    }
    public function availabilityAction()
    {
        if(!$this->availability)$this->availability = new \Management\Entity\Availability;
        return array(
            'session' => $this->session,
            'availability' => $this->getEntity('Availability', null, $_GET['entityId']),
            'entity'  => $this->getEntity('Availability', null, $_GET['entityId']),
        ); 
    }
    public function uomAction()
    {
        if(!$this->uom)$this->uom = new \Management\Entity\Uom;
        return array(
            'session' => $this->session,
            'uom' => $this->getEntity('Uom', null, $_GET['entityId']),
        ); 
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
