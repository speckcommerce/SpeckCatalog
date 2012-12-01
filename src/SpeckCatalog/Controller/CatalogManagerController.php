<?php

namespace SpeckCatalog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter as ArrayAdapter;
use SpeckCatalog\Service\FormServiceAwareInterface;
use Zend\Stdlib\Hydrator\ClassMethods as Hydrator;

class CatalogManagerController
    extends AbstractActionController
    implements FormServiceAwareInterface
{
    protected $testService;
    protected $userAuth;
    protected $formService;
    protected $productService;
    protected $optionService;
    protected $choiceService;
    protected $categoryService;
    protected $sitesService;
    protected $partialDir = '/speck-catalog/catalog-manager/partial/';

    public function __construct($userAuth = null)
    {
        //if (false === $userAuth->hasIdentity()) {
        //    $this->redirect()->toRoute('zfcuser');
        //}
        //$this->userAuth = $userAuth;
    }

    public function layout($layout)
    {
        if (false === $layout) {
            $this->getEvent()->getViewModel()->setTemplate('layout/nolayout');
        } else {
            parent::layout($layout);
        }
    }

    public function indexAction()
    {
        $this->getUserAuth();

        $productService = $this->getProductService();
        $companyService = $this->getCompanyService();

        $products = $productService->getAll();
        $companies = $companyService->getAll();

        return new ViewModel(
            array(
                'products' => $products,
                'companies' => $companies,

            )
        );
    }

    public function categoryTreePreviewAction()
    {
        $categoryService = $this->getCategoryService();
        $siteId = $this->params('siteid');
        $categories = $categoryService->getCategoriesForTreePreview($siteId);

        $view = new ViewModel(array('categories' => $categories));
        $view->setTemplate($this->partialDir . 'category-tree')
             ->setTerminal(true);

        return $view;
    }

    //find categories/products that match search terms
    public function categorySearchChildrenAction()
    {
        $getter = 'get' . ucfirst($this->params('type')) . 'Service';
        $service = $this->$getter();
        $children = $service->getAll();

        $view = new ViewModel(
            array(
                'children' => $children,
                'type' => $this->params('type')
            )
        );
        $view->setTemplate($this->partialDir . 'category-search-children')
             ->setTerminal(true);
        return $view;
    }

    public function newProductAction()
    {
        $product = $this->getProductService()->getEntity();
        return new ViewModel(array('product' => $product));
    }

    public function productsAction()
    {
        $productService = $this->getProductService();
        $products = $productService->getAll();
        return new ViewModel(array('products' => $products));
    }

    public function categoriesAction()
    {
        $sites = $this->getSitesService()->getAll();
        $categories = $this->getCategoryService()->getAll();
        return new ViewModel(
            array(
                'categories' => $categories,
                'sites' => $sites,
            )
        );
    }

    public function productAction()
    {
        $productService = $this->getProductService();
        $product = $productService->getFullProduct($this->params('id'));
        return new ViewModel(array('product' => $product));
    }

    //return the partial for a new record.
    public function newPartialAction()
    {
        $this->layout(false);
        $params = $this->params()->fromPost();

        $serviceName = 'speckcatalog_' . $params['parent_name'] . '_service';
        $parentService = $this->getServiceLocator()->get($serviceName);
        $parent = $parentService->find($params['parent']);

        $serviceName = 'speckcatalog_' . $params['child_name'] . '_service';
        $childService = $this->getServiceLocator()->get($serviceName);
        $child = $childService->getEntity();

        $child->setParent($parent);

        $partial = $this->dash($params['child_name']);
        $view = new ViewModel(
            array(lcfirst($this->camel($params['child_name'])) => $child)
        );

        return $view->setTemplate($this->partialDir . $partial);
    }

    public function updateRecordAction()
    {
        $this->layout(false);
        $class = $this->params('class');
        $serviceName =  'speckcatalog_' . $class . '_service';
        $service = $this->getServiceLocator()->get($serviceName);
        $form = $this->getFormService()->getForm($class, null, $_POST);

        if ($form->isValid()) {
            $originalData = $form->getOriginalData();
            $data = $form->getData();
            if (count($originalData) && $service->find($originalData)) {
                $service->update($data, $originalData);
                $entity = $service->find($data, true);
            } else {
                $entity = $service->insert($data);
            }
            if ($entity instanceOf \SpeckCatalog\Model\Product) {
                echo (int) $entity->getProductId();
                die();
            }
        } else {
            $hydrator = new Hydrator;
            $entity = $service->getEntity();
            $hydrator->hydrate($form->getData(), $entity);
        }

        $view = new ViewModel(
            array(lcfirst($this->camel($class)) => $entity)
        );
        return $view->setTemplate($this->partialDir . $this->dash($class));
    }

    /**
     * updateFormAction
     *
     * @return message stringvoid
     */
    public function updateFormAction()
    {
        $this->layout(false);

        $class = $this->params('class');
        $serviceLocator = $this->getServiceLocator();
        $formService = $this->getFormService();
        $form = $formService->getForm($class, null, $_POST);
        $viewHelperManager = $serviceLocator->get('viewhelpermanager');
        $formViewHelper = $viewHelperManager->get('speckCatalogForm');
        $messageHtml = $formViewHelper->renderFormMessages($form);

        $response = $this->getResponse()->setContent($messageHtml);
        return $response;
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
        $postParams = $this->params()->fromPost();
        $type = $this->params('type');
        $parent = $this->params('parent');
        $parentKey = $postParams['parent_key'];

        $order = explode(',', $postParams['order']);
        foreach ($order as $i => $val) {
            if (!trim($val)) {
                unset($order[$i]);
            }
        }
        $getter = 'get' . $this->camel($parent) . 'Service';
        $parentService =  $this->$getter();

        $sortChildren = 'sort' . $this->camel($type) . 's';
        $parentService->$sortChildren($parentKey, $order);

        return $this->getResponse();
    }


    public function removeChildAction()
    {
        $this->layout(false);

        $postParams = $this->params()->fromPost();
        $parentName = $postParams['parent_name'];
        $parentKey  = $postParams['parent'];
        $childName  = $postParams['child_name'];
        $childKey   = $postParams['child'];

        $getParentService = 'get' . $this->camel($parentName) . 'Service';
        $parentService = $this->$getParentService();

        $removeChildMethod = 'remove' . $this->camel($childName);
        $result = $parentService->$removeChildMethod($parentKey, $childKey);

        $response = $this->getResponse();
        if (true === $result) {
            $response->setContent('true');
        }
        return $response;
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
            $this->productService = $this->getServiceLocator()->get('speckcatalog_product_service');
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
            $this->categoryService = $this->getServiceLocator()->get('speckcatalog_category_service');
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

    /**
     * @return sitesService
     */
    public function getSitesService()
    {
        if (null === $this->sitesService) {
            $this->sitesService = $this->getServiceLocator()->get('speckcatalog_sites_service');
        }
        return $this->sitesService;
    }

    /**
     * @param $sitesService
     * @return self
     */
    public function setSitesService($sitesService)
    {
        $this->sitesService = $sitesService;
        return $this;
    }

    /**
     * @return optionService
     */
    public function getOptionService()
    {
        if (null === $this->optionService) {
            $this->optionService = $this->getServiceLocator()->get('speckcatalog_option_service');
        }
        return $this->optionService;
    }

    /**
     * @param $optionService
     * @return self
     */
    public function setOptionService($optionService)
    {
        $this->optionService = $optionService;
        return $this;
    }

    /**
     * @return choiceService
     */
    public function getChoiceService()
    {
        if (null === $this->choiceService) {
            $this->choiceService = $this->getServiceLocator()->get('speckcatalog_choice_service');
        }
        return $this->choiceService;
    }

    /**
     * @param $choiceService
     * @return self
     */
    public function setChoiceService($choiceService)
    {
        $this->choiceService = $choiceService;
        return $this;
    }
}
