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
    protected $testService;
    protected $userAuth;
    protected $formService;
    protected $productService;
    protected $categoryService;

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

    public function newProductAction()
    {
        if (0) {
            $this->updateRecordAction($data);
            $this->redirect()->toRoute("/catalogmanager/product/{$id}");
        }
        $product = $this->getProductService()->getEntity();

        return new ViewModel(array('product' => $product));
    }

    public function productsAction()
    {
        $products = $this->getServiceLocator()->get('catalog_product_service')->getAll();
        return new ViewModel(array('products' => $products));
    }

    public function categoriesAction()
    {
        $categories = $this->getCategoryService()->getAll();
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


    //return the partial for a new record.
    public function newPartialAction()
    {
        $this->layout(false);
        $params = $this->params()->fromPost();

        $parentService = $this->getServiceLocator()->get('catalog_' . $params['parent_name'] . '_service');
        $parent = $parentService->find($params['parent']);

        $childService = $this->getServiceLocator()->get('catalog_' . $params['child_name'] . '_service');
        $child = $childService->getEntity();

        $child->setParent($parent);

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
            if (count($form->getOriginalData()) && $service->find($form->getOriginalData())) {
                $service->update($form->getData(), $form->getOriginalData());
                $entity = $service->find($form->getData(), true);
            } else {
                $entity = $service->insert($form->getData());
            }

            if ($entity instanceOf \Catalog\Model\Product) {
                echo (int) $entity->getProductId();
                die();
            }
        } else {
            $hydrator = new Hydrator;
            $entity = $service->getEntity();
            $hydrator->hydrate($form->getData(), $entity);
        }

        $view = new ViewModel(array(
            lcfirst($this->camel($class)) => $entity
        ));
        return $view->setTemplate("catalog/catalog-manager/partial/" . $this->dash($class) . '.phtml');
    }

    public function updateFormAction()
    {
        $this->layout(false);
        $class = $this->params('class');

        $service = $this->getServiceLocator()->get('catalog_' . $class . '_service');
        $form = $this->getFormService()->getForm($class, null, $_POST);

        $messages = $this->getServiceLocator()->get('viewhelpermanager')->get('speckCatalogForm')->renderFormMessages($form);
        die($messages);
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

    /**
     * @return productService
     */
    public function getProductService()
    {
        if (null === $this->productService) {
            $this->productService = $this->getServiceLocator()->get('catalog_product_service');
        }
        return $this->productService;
    }

    /**
     * @param $productService
     * @return self
     */
    public function setProductService($productService)
    {
        $this->productService = $productService;
        return $this;
    }

    /**
     * @return categoryService
     */
    public function getCategoryService()
    {
        if (null === $this->categoryService) {
            $this->categoryService = $this->getServiceLocator()->get('catalog_category_service');
        }
        return $this->categoryService;
    }

    /**
     * @param $categoryService
     * @return self
     */
    public function setCategoryService($categoryService)
    {
        $this->categoryService = $categoryService;
        return $this;
    }
}
