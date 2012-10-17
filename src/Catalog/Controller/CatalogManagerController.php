<?php

namespace Catalog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter as ArrayAdapter;
use Catalog\Service\FormServiceAwareInterface;
use Zend\Stdlib\Hydrator\ClassMethods as Hydrator;

class CatalogManagerController
    extends AbstractActionController
    implements FormServiceAwareInterface
{
    protected $linkerService;
    protected $testService;
    protected $userAuth;
    protected $formService;

    public function __construct($userAuth = null)
    {
        //if (false === $userAuth->hasIdentity()) {
        //    $this->redirect()->toRoute('zfcuser');
        //}
        //$this->userAuth = $userAuth;
    }

    public function layout($layout)
    {
        if(false === $layout){
            $this->getEvent()->getViewModel()->setTemplate('layout/nolayout');
        }else{
            parent::layout($layout);
        }

    }

    public function indexAction()
    {
        $this->getUserAuth();

        $products = $this->getServiceLocator()->get('catalog_product_service')->getAll();
        $companies = $this->getServiceLocator()->get('catalog_company_service')->getAll();
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

        return $this->redirect()->toRoute('catalogmanager/' . $class, array('id' => $model->getId()));
    }

    public function productsAction()
    {
        $products = $this->getServiceLocator()->get('catalog_product_service')->getAll();
        return new ViewModel(array('products' => $products));
    }

    public function companiesAction()
    {
        $companies = $this->getCatalogService()->getCompanies();
        return new ViewModel(array('companies' => $companies));
    }

    public function categoriesAction()
    {
        $categories = $this->getCatalogService()->getService('category')->getCategoriesForManagement();
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
        $category = $this->getCatalogService()->getModel('category', $this->params('id'));
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
        $productService = $this->getServiceLocator()->get('catalog_product_service');
        $product = $productService->getFullProduct($this->params('id'));
        return new ViewModel(array('product' => $product));
    }

    public function newPartialAction()
    {
        $this->layout(false);
        $params = $this->params()->fromPost();

        $childService = $this->getServiceLocator()->get('catalog_' . $params['child_name'] . '_service');
        $parentService = $this->getServiceLocator()->get('catalog_' . $params['parent_name'] . '_service');

        $parent = $parentService->find($params['parent']);
        $child = $childService->getEntity();

        $hydrator = new Hydrator;
        $hydrator->hydrate($params['parent'], $child);

        $addMethod = 'add' . $this->camel($params['child_name']);
        $child = $parentService->$addMethod($parent, $child);

        $partial = $this->dash($params['child_name']);
        $view = new ViewModel(array(
            lcfirst($this->camel($params['child_name'])) => $child,
        ));
        return $view->setTemplate('catalog/catalog-manager/partial/' . $partial);
    }

    public function updateRecordAction()
    {
        $this->layout(false);
        $class = $this->params('class');
        $service = $this->getServiceLocator()->get('catalog_' . $class . '_service');
        $form = $this->getFormService()->getForm($class, null, $_POST);
        if($form->isValid()){
            $service->update($form->getData(), $form->getOriginalData());
        } else {
            echo "form was not valid!";
        }
        $entity = $service->find($form->getData(), true);
        $view = new ViewModel(array('form' => $form, $class => $entity));
        return $view->setTemplate("catalog/catalog-manager/partial/form/" . $this->dash($class) . '.phtml');
    }

    private function dash($name)
    {
        $dash = new \Zend\Filter\Word\UnderscoreToDash;
        return $dash->__invoke($name);
    }

    private function camel($name)
    {
        $camel = new \Zend\Filter\Word\UnderscoreToCamelCase;
        return $camel->__invoke($name);
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
        return $this->formService;
    }

    public function setFormService($formService)
    {
        $this->formService = $formService;
        return $this;
    }
}
