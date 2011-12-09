<?php

namespace Management\Controller;

use Zend\Mvc\Controller\ActionController;

class IndexController extends ActionController
{
    protected $shell;
    protected $product;
    protected $option;
    protected $choice;
    protected $company;
    protected $productUom;
    protected $uom;
    
    public function __construct()
    {
        $factory = new \Management\Service\EntityFactoryService;
        $shell = $factory->shellFactory('product')->setName('ShellName');
        $this->shell = $shell;
        
        
      //$shell = $factory->shellFactory('product')->setName('ShellName');
      //$company = new \Management\Entity\Company;
      //$company->setName('CompanyName');
      //$availability = $factory->availabilityFactory();
      //$uom = new \Management\Entity\Uom; $uom->setName('UomName');
      //$productUom = $factory->productUomFactory($uom);
      //$productUom->addAvailability($availability);
      //
      //$product = $factory->productFactory($company)->setName('ProductName')->addUom($productUom);
      //$choice = $factory->choiceFactory()->setName('ChoiceName');
      //$shell->setProduct($product)->setParentChoices(array($choice, $choice, $choice)); 
      //$option1 = $factory->optionFactory('radio');
      //$option1->setName('OptionName');
      //$choice1 = $factory->choiceFactory()->setName('ChoiceName');
      //$option1->setChoices(array($choice1, $choice1))->setSelectedChoice($choice1);
      //$shell->setOptions(array($option1, $option1));
      //
      //$this->shell = $shell;
      //$this->company = $company->setProducts(array($product))->setAvailabilities(array($availability, $availability));
      //$this->productUom = $productUom->setParentProduct($product);
      //$this->uom = $uom->setParentProductUoms(array($productUom, $productUom));
      //$this->availability = $availability->setParentProductUom($productUom)->setDistributor($company);
      //$this->product = $product->setParentShell($shell);
      //$this->option = $option1->setParentShells(array($shell, $shell));
      //$this->choice = $choice1->setParentOptions(array($option1, $option1))->setShell($shell);
    }
    
    public function indexAction()
    {
        die('index');
    }

    public function shellAction()
    {
        $user = $this->getLocator()->get('speckcatalog_user_service')->getAuthService()->getIdentity();
        $this->session = $this->getLocator()->get('catalog_management_service')->getSession($user);
        return array(
            'session' => $this->session,
            'shell' => $this->shell,
        ); 
    }
    public function productAction()
    {
        $user = $this->getLocator()->get('speckcatalog_user_service')->getAuthService()->getIdentity();
        $this->session = $this->getLocator()->get('catalog_management_service')->getSession($user);
        return array(
            'session' => $this->session,
            'product' => $this->product,
        ); 
    }
    public function optionAction()
    {
        $user = $this->getLocator()->get('speckcatalog_user_service')->getAuthService()->getIdentity();
        $this->session = $this->getLocator()->get('catalog_management_service')->getSession($user);
        return array(
            'session' => $this->session,
            'option' => $this->option,
        ); 
    }
    public function choiceAction()
    {
        $user = $this->getLocator()->get('speckcatalog_user_service')->getAuthService()->getIdentity();
        $this->session = $this->getLocator()->get('catalog_management_service')->getSession($user);
        return array(
            'session' => $this->session,
            'choice' => $this->choice,
        ); 
    }
    public function companyAction()
    {
        $user = $this->getLocator()->get('speckcatalog_user_service')->getAuthService()->getIdentity();
        $this->session = $this->getLocator()->get('catalog_management_service')->getSession($user);
        return array(
            'session' => $this->session,
            'company' => $this->company,
        ); 
    }
    public function productUomAction()
    {
        $user = $this->getLocator()->get('speckcatalog_user_service')->getAuthService()->getIdentity();
        $this->session = $this->getLocator()->get('catalog_management_service')->getSession($user);
        return array(
            'session' => $this->session,
            'productUom' => $this->productUom,
        ); 
    }
    public function availabilityAction()
    {
        $user = $this->getLocator()->get('speckcatalog_user_service')->getAuthService()->getIdentity();
        $this->session = $this->getLocator()->get('catalog_management_service')->getSession($user);
        return array(
            'session' => $this->session,
            'availability' => $this->availability,
        ); 
    }
    public function uomAction()
    {
        $user = $this->getLocator()->get('speckcatalog_user_service')->getAuthService()->getIdentity();
        $this->session = $this->getLocator()->get('catalog_management_service')->getSession($user);
        return array(
            'session' => $this->session,
            'uom' => $this->uom,
        ); 
    } 
}
