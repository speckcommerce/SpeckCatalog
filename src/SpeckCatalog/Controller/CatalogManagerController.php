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

    public function init()
    {
        $this->subLayout('layout/catalog-manager');
    }

    //find categories/products that match search terms
    public function categorySearchChildrenAction()
    {
        $type = $this->params('type');
        $children = $this->getService($type)->getAll();

        $viewVars = ['children' => $children, 'type' => $type];
        return $this->partialView('category-search-children', $viewVars);
    }

    public function newProductAction()
    {
        $this->init();
        $product = $this->getService('product')->getModel();
        return new ViewModel(['product' => $product]);
    }

    public function categoryTreePreviewAction()
    {
        $siteId = $this->params('siteid');
        $categoryService = $this->getService('category');
        $categories = $categoryService->getCategoriesForTreePreview($siteId);

        $viewVars = ['categories' => $categories];
        return $this->partialView('category-tree', $viewVars);
    }

    public function productsAction()
    {
        $service = $this->getService('product');

        $this->init();
        $config = [
            'p' => $this->params('p') ?: 1,
            'n' => 40,
        ];
        $service->usePaginator($config);
        $query = $this->params()->fromQuery('query');
        if ($query) {
            $products = $service->search($query);
        } else {
            $products = $service->getAll();
        }
        return new ViewModel(['products' => $products, 'query' => $query]);
    }

    public function categoriesAction()
    {
        $this->init();
        $sites = $this->getService('sites')->getAll();
        return new ViewModel(['sites' => $sites]);
    }

    public function productAction()
    {
        $this->init();
        $productService = $this->getService('product');
        $product = $productService->getFullProduct($this->params('id'));

        $vars = ['product' => $product];
        return new ViewModel($vars);
    }


    //returns main view variable(product/option/etc)
    protected function persist($class, $form)
    {
        $service = $this->getService($class);

        if (method_exists($service, 'persist')) {
            return $service->persist($form);
        }

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

        return $this->partialView('product', ['product' => $product]);
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
        $viewVars = [lcfirst($this->camel($class)) => $entity];
        return $this->partialView($partial, $viewVars);
    }

    public function updateFormAction()
    {
        $data   = $this->params()->fromPost();
        $form   = $this->getService('form')->getForm($this->params('class'), null, $data);
        $helper = $this->getViewHelper('speckCatalogForm');

        $html   = $helper->renderFormMessages($form);
        return $this->getResponse()->setContent($html);
    }

    public function getViewHelper($helperName)
    {
        return $this->getServiceLocator()->get('viewhelpermanager')->get($helperName);
    }

    public function findAction()
    {
        $post = $this->params()->fromPost();

        if (!isset($post['query'])) {
            $search = $this->partialDir . 'search/' . $this->dash($post['child_name']);
            $view   = new ViewModel([
                'fields'        => $post,
                'searchPartial' => $search
            ]);
            return $view->setTemplate($this->partialDir . 'search/index')->setTerminal(true);
        }

        $response = [
            'html' => '',
        ];
        $result = $this->getService($post['parent_name'])->search($post);
        if (count($result) > 0) {
            $partial = $this->getViewHelper('partial');
            $rowPartial = $this->partialDir . 'search/row/' . $this->dash($post['child_name']);
            foreach ($result as $row) {
                $response['html'] .= $partial($rowPartial, ['model' => $row, 'params' => $post]);
            }
        } else {
            $response['html'] = 'no result';
        }
        $json_resp = json_encode($response);
        return $this->getResponse()->setContent($json_resp);







        return $view;
    }

    public function foundAction()
    {
        $postParams = $this->params()->fromPost();

        $objects = [];

        if ($postParams['child_name'] === 'builder_product') {
            $parentProductId = $postParams['parent']['product_id'];
            $productIds = array_keys($postParams['check']);
            foreach ($productIds as $productId) {
                $objects[] = $this->getService('builder_product')->newBuilderForProduct($productId, $parentProductId);
            }
        }

        $helper   = $this->getViewHelper('speckCatalogRenderChildren');
        $content  = $helper->__invoke($postParams['child_name'], $objects);
        $response = $this->getResponse()->setContent($content);
        return $response;
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
        return $this->getResponse()->setContent('false');
    }

    public function getService($name)
    {
        $serviceName = 'speckcatalog_' . $name . '_service';
        return $this->getServiceLocator()->get($serviceName);
    }

    //return the partial for a new record.
    public function newPartialAction()
    {
        $postParams = $this->params()->fromPost();
        $parentName = $postParams['parent_name'];
        $childName  = $postParams['child_name'];
        $parent     = $postParams['parent'];

        $parent = $this->getService($parentName)->find($parent);
        $child  = $this->getService($childName)->getModel();

        $child->setParent($parent);

        $partial  = $this->dash($childName);
        $viewVars = [lcfirst($this->camel($childName)) => $child];
        return $this->partialView($partial, $viewVars);
    }

    public function partialView($partial, array $viewVars = null)
    {
        $view = new ViewModel($viewVars);
        $view->setTemplate($this->partialDir . $partial);
        $view->setTerminal(true);

        return $view;
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
