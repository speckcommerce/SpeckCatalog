<?php

namespace CatalogManager\Controller;

use Zend\Mvc\Controller\ActionController,
    Zend\View\Model\ViewModel,
    Zend\Paginator\Paginator,
    Zend\Paginator\Adapter\ArrayAdapter as ArrayAdapter,
    CatalogManager\Service\FormService;

class CatalogManagerController extends ActionController
{
    protected $catalogService;
    protected $linkerService;
    protected $testService;
    protected $userAuth;
    protected $formService;

    public function __construct($userAuth)
    {
        //if (false === $userAuth->hasIdentity()) {
        //    $this->redirect()->toRoute('zfcuser');
        //}
        $this->userAuth = $userAuth;
    }

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
        $this->getUserAuth();
        $products = $this->getCatalogService()->getAll('product');
        $companies = $this->getCatalogService()->getAll('company');
        return new ViewModel(array(
            'products' => $products,
            'companies' => $companies
        ));
    }

    public function newAction()
    {
        $class = $this->getEvent()->getRouteMatch()->getParam('class');
        $constructor = $this->getEvent()->getRouteMatch()->getParam('constructor');
        $model = $this->getCatalogService()->newModel($class, $constructor);
        return $this->redirect()->toRoute('catalogmanager/' . $class, array('id' => $model->getRecordId()));
    }

    public function productsAction()
    {
        $products = $this->getCatalogService()->getAll('product');
        $paginator = new Paginator(new ArrayAdapter($products));
        $page = $this->getEvent()->getRouteMatch()->getParam('page');
        if($page){
            $paginator->setCurrentPageNumber($page);
        }
        if((int)$page === 0)$page=1;
        return new ViewModel(array('products' => $paginator, 'page' => (int)$page));
    }

    public function companiesAction()
    {
        $companies = $this->getCatalogService()->getCompanies();
        return new ViewModel(array('companies' => $companies));
    }

    public function categoriesAction()
    {
        $categories = $this->getCatalogService()->getCategories();
        return new ViewModel(array('categories' => $categories));
    }

    public function companyAction()
    {
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        $company = $this->getCatalogService()->getModel('company', $id);
        return new ViewModel(array('company' => $company));
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
        $productForm = $this->getFormService()->getForm('product', $product);

        return new ViewModel(array(
            'product' => $product,
            'productForm' => $productForm
        ));
    }

    public function fetchPartialAction()
    {
        $this->layout(false);
        $partialName = $_POST['partial_name'];
        $class = ($_POST['class_name'] ? $_POST['class_name'] : $_POST['new_class_name']);
        $model = $this->getLinkerService()->linkModel($_POST);
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

    public function sortAction()
    {
        $order = explode(',', $_POST['order']);
        $type = $this->getEvent()->getRouteMatch()->getParam('type');
        $parent = $this->getEvent()->getRouteMatch()->getParam('parent');
        die($this->getCatalogService()->updateSortOrder($type, $parent, $order));
    }

    public function removeAction()
    {
        $type = $this->getEvent()->getRouteMatch()->getParam('type');
        $linkerId = $this->getEvent()->getRouteMatch()->getParam('linkerId');
        die($this->getLinkerService()->removeLinker($type, $linkerId));
    }

    public function getCatalogService()
    {
        return $this->getServiceLocator()->get('catalog_generic_service');
    }

    public function setCatalogService($catalogService)
    {
        $this->catalogService = $catalogService;
        return $this;
    }

    public function getLinkerService()
    {
        return $this->getServiceLocator()->get('catalog_model_linker_service');
    }

    public function setLinkerService($linkerService)
    {
        $this->linkerService = $linkerService;
        return $this;
    }

    public function getUserAuth()
    {
        return $this->userAuth;
    }

    public function setUserAuth($userAuth)
    {
        $this->userService = $userService;
        return $this;
    }

    public function getFormService()
    {
        if(null === $this->formService){
            $this->formService = $this->getServiceLocator()->get('catalogmanager_form_service');
        }
        return $this->formService;
    }

    public function setFormService($formService)
    {
        $this->formService = $formService;
        return $this;
    }
}
