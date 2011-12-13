<?php

namespace SpeckCatalogManager\Controller;

use Zend\Mvc\Controller\ActionController,
    \Exception;

class IndexController extends ActionController
{
    protected $userService;
    protected $catalogService;
    protected $shell;
    protected $product;
    protected $option;
    protected $choice;
    protected $company;
    protected $productUom;
    protected $uom;
    protected $availability;
    
    public function __construct()
    {
        if(!isset($_GET['constructor'])){
            $_GET['constructor'] = null;
        }
        if(!isset($_GET['entityId'])){
            $_GET['entityId'] = null;
        }
    }
    
    public function indexAction()
    {
        return array(
            'session' => $this->session,
            'paginator' => $this->paginate(null, $this->session->getEntities(), 1)
        );
    }
    
    private function paginate($pageNum=1, $items=null, $perPage=null)
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

    public function shellAction()
    {
        $entity = $this->getEntity('Shell', $_GET['constructor'], $_GET['entityId']);
        $formManager = $this->getFormManager($entity);

        return array(                
            'session' => $this->session,
            'shell' => $entity,
            'form' => $formManager->getForm(),
        ); 
    }
    public function productAction()
    {
        $entity = $this->getEntity('Product', $_GET['constructor'], $_GET['entityId']);

        $formManager = $this->getFormManager($entity);

        return array(                
            'session' => $this->session,
            'product' => $entity,
            'form' => $formManager->getForm(),
        ); 
        
        if(!$this->product)$this->product = new \Management\Entity\Product;
        return array(
            'session' => $this->session,
            'product' => $this->getEntity('Product', null, $_GET['entityId']),
            'entity'  => $this->getEntity('Product', null, $_GET['entityId']),
        ); 
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
        if(!$this->choice)$this->choice = new \Management\Entity\Choice;
        return array(
            'session' => $this->session,
            'choice' => $this->getEntity('Choice', null, $_GET['entityId']),
            'entity'  => $this->getEntity('Choice', null, $_GET['entityId']),
        ); 
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
        $this->user = $this->userService->getAuthService()->getIdentity();
        if(!$this->user) $this->user="not logged in";
    }

    public function setSessionService($catalogManagerService)
    {
        $this->sessionService = $catalogManagerService;
        $this->session = $this->sessionService->getSession($this->user);

        $entities= $this->session->getEntities();
        foreach($entities as $i => $entity){
            $class = get_class($entity);
            $classArr = explode('\\', $class);
            $className = array_pop($classArr);    
            $entities[$i] = "({$i}){$className}";
        } 
    }
}
