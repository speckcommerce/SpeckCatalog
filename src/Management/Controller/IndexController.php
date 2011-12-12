<?php

namespace Management\Controller;

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
        die('index');
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
            $class = '\management\Entity\\'.$className;
            try {
                return new $class($constructor);
            } catch (Exception $e) {
                die('heres your error - '.$e);
            }
            
        } 
    }

    public function shellAction()
    {
        $entity = $this->getEntity('Shell', $_GET['constructor'], $_GET['entityId']);
        $manager = $this->getLocator()
            ->get('spiffy_form', array('definition' => 'Catalog\Form\Definition\Shell','data' => $entity,))
            ->build();

        return array(                
            'session' => $this->session,
            'shell' => $entity,
            'form' => $manager->getForm(),
        ); 
    }
    public function productAction()
    {
        $entity = $this->getEntity('Product', $_GET['constructor'], $_GET['entityId']);
        $manager = $this->getLocator()
            ->get('spiffy_form', array('definition' => 'Catalog\Form\Definition\Product','data' => $entity,))
            ->build();

        return array(                
            'session' => $this->session,
            'product' => $entity,
            'form' => $manager->getForm(),
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
    }

    public function setCatalogService($catalogService)
    {
        $this->catalogService = $catalogService;
        $this->session = $this->catalogService->getSession($this->user);
        $entities= $this->session->getEntities();
        foreach($entities as $i => $entity){
            $class = get_class($entity);
            $classArr = explode('\\', $class);
            $className = array_pop($classArr);    
            $entities[$i] = "({$i}){$className}";
        } 
        var_dump('session = '.implode(',',$entities));
    }
}
