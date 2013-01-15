<?php

namespace SpeckCatalog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter as ArrayAdapter;
use Zend\Stdlib\Hydrator\ClassMethods as Hydrator;

class CatalogManagerController extends AbstractActionController
{
    protected $partialDir = '/speck-catalog/catalog-manager/partial/';

    public function indexAction()
    {
        $products = $this->getService('product')->getAll();
        $companies = $this->getService('company')->getAll();

        $viewVars = array('products' => $products, 'companies' => $companies);
        return new ViewModel($viewVars);
    }

    public function categoryTreePreviewAction()
    {
        $siteId = $this->params('siteid');
        $categoryService = $this->getService('category');
        $categories = $categoryService->getCategoriesForTreePreview($siteId);

        $viewVars = array('categories' => $categories);
        return $this->partialView('category-tree', $viewVars);
    }

    //find categories/products that match search terms
    public function categorySearchChildrenAction()
    {
        $type = $this->params('type');
        $children = $this->getService($type)->getAll();

        $viewVars = array('children' => $children, 'type' => $type);
        return $this->partialView('category-search-children', $viewVars);
    }

    public function newProductAction()
    {
        $product = $this->getService('product')->getEntity();
        return new ViewModel(array('product' => $product));
    }

    public function productsAction()
    {
        $products = $this->getService('product')->getAll();
        return new ViewModel(array('products' => $products));
    }

    public function categoriesAction()
    {
        $sites = $this->getSitesService()->getAll();
        return new ViewModel(array('sites' => $sites));
    }

    public function productAction()
    {
        $productService = $this->getService('product');
        $product = $productService->getFullProduct($this->params('id'));
        return new ViewModel(array('product' => $product));
    }

    //return the partial for a new record.
    public function newPartialAction()
    {
        $postParams = $this->params()->fromPost();
        $parentName = $postParams['parent_name'];
        $childName  = $postParams['child_name'];
        $parent     = $postParams['parent'];

        $parent = $this->getService($parentName)->find($parent);
        $child  = $this->getService($childName)->getEntity();

        $child->setParent($parent);

        $partial = $this->dash($childName);
        $viewVars = array(lcfirst($this->camel($childName)) => $child);
        return $this->partialView($partial, $viewVars);
    }

    //returns entity
    protected function persist($class, $form)
    {
        $service = $this->getService($class);
        $originalData = $form->getOriginalData();
        $data = $form->getData();

        if (count($originalData) && $service->find($originalData)) {
            $service->update($data, $originalData);
            return $service->find($data, true, true);
        }

        return $service->insert($data);
    }

    public function updateProductAction()
    {
        $formData = $this->params()->fromPost();
        $form = $this->getService('form')->getForm('product', null, $formData);

        if ($form->isValid()) {
            $product = $this->persist('product', $form);
            return $this->getResponse()->setContent($product->getProductId());
        }

        return $this->partialView('product', array('product' => $product));
    }

    public function updateRecordAction()
    {
        $class = $this->params('class');
        $formData = $this->params()->fromPost();
        $form = $this->getService('form')->getForm($class, null, $formData);

        if ($form->isValid()) {
            $entity = $this->persist($class, $form);
        } else {
            $entity = $this->getService($class)->getEntity($formData);
        }

        $partial = $this->dash($class);
        $viewVars = array(lcfirst($this->camel($class)) => $entity);
        return $this->partialView($partial, $viewVars);
    }

    public function updateFormAction()
    {
        $class = $this->params('class');
        $serviceLocator = $this->getServiceLocator();
        $formService = $this->getService('form');
        $formData = $this->params()->fromPost();
        $form = $formService->getForm($class, null, $formData);
        $viewHelperManager = $serviceLocator->get('viewhelpermanager');
        $formViewHelper = $viewHelperManager->get('speckCatalogForm');
        $messageHtml = $formViewHelper->renderFormMessages($form);

        $response = $this->getResponse()->setContent($messageHtml);
        return $response;
    }

    public function findAction()
    {
        $postParams = $this->params()->fromPost();

        $models = array();
        //todo :finish this up - just getting all products (with paginator) for now.
        if(isset($postParams['query'])) {
            $models = $this->getService($postParams['parent_name'])->usePaginator()->getAll();
        }

        $this->layout(false);
        $view = new ViewModel(array('models' => $models, 'fields' => $postParams));
        $view->setTemplate($this->partialDir . 'find-models');
        return $view;
    }

    public function foundAction()
    {
        $postParams = $this->params()->fromPost();

        if ($postParams['child_name'] === 'builder_product') {
            foreach($postParams['check'] as $key => $checked) {
                $productIds[] = $postParams['product_id'][$key];
            }
            $products = $this->getService('product')->getBuilderProductsForEdit($productIds);
            $choices = $this->getService('product')->getAllChoicesByProductId($postParams['parent']['product_id']);

            $container = new ViewModel();
            $container->setTemplate('/layout/nolayout')->setTerminal(true);
            foreach($products as $product) {
                $view = new ViewModel(array('product' => $product, 'choices' => $choices));
                $view->setTemplate($this->partialDir . 'builder-product');
                $container->addChild($view);
            }
        }
        return $container->setTerminal(true);
    }

    public function sortAction()
    {
        $postParams = $this->params()->fromPost();
        $childName  = $this->params('type');
        $parentName = $this->params('parent');
        $parent     = $postParams['parent_key'];

        $order = explode(',', $postParams['order']);
        foreach ($order as $i => $val) {
            if (!trim($val)) {
                unset($order[$i]);
            }
        }
        $parentService = $this->getService($parentName);
        $sortChildren = 'sort' . $this->camel($childName) . 's';
        $result = $parentService->$sortChildren($parent, $order);

        return $this->getResponse();
    }

    public function removeChildAction()
    {
        $postParams = $this->params()->fromPost();
        $parentName = $postParams['parent_name'];
        $childName  = $postParams['child_name'];
        $parent     = $postParams['parent'];
        $child      = $postParams['child'];

        $parentService = $this->getService($parentName);

        $removeChildMethod = 'remove' . $this->camel($childName);
        $result = $parentService->$removeChildMethod($parent, $child);

        if (true === $result) {
            return $this->getResponse()->setContent('true');
        }
        $this->getResponse();
    }

    public function getService($name)
    {
        $serviceName = 'speckcatalog_' . $name . '_service';
        return $this->getServiceLocator()->get($serviceName);
    }

    public function partialView($partial, array $viewVars=null)
    {
        $this->layout(false);
        $view = new ViewModel($viewVars);
        $view->setTemplate($this->partialDir . $partial);
        return $view;
    }

    public function layout($layout)
    {
        if (false === $layout) {
            $this->getEvent()->getViewModel()->setTemplate('layout/nolayout');
        } else {
            parent::layout($layout);
        }
    }

    protected function dash($name)
    {
        $dash = new \Zend\Filter\Word\UnderscoreToDash;
        return $dash->__invoke($name);
    }

    protected function camel($name)
    {
        $camel = new \Zend\Filter\Word\UnderscoreToCamelCase;
        return $camel->__invoke($name);
    }
}
