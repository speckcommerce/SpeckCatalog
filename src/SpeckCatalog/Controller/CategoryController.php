<?php

namespace SpeckCatalog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Exception;

class CategoryController extends AbstractActionController
{
    protected $catalogService;

    public function indexAction()
    {
        $paginatorVars = $this->getPaginatorVars();

        $id       = $this->params('id');
        $service  = $this->getServiceLocator()->get('speckcatalog_category_service');
        $category = $service->getCategoryForView($id, $paginatorVars);

        $crumbs = $service->getCrumbs($category);
        $this->layout()->crumbs = array(
            'type' => 'category',
            'crumbs' => $crumbs,
        );

        if (null === $category) {
            throw new \Exception('fore oh fore');
        }

        $paginatorVars['categoryId'] = $category->getCategoryId();

        return new ViewModel(array(
            'category' => $category,
            'paginatorVars' => $paginatorVars,
        ));
    }

    public function setCatalogService($catalogService)
    {
        $this->catalogService = $catalogService;
    }

    public function getCatalogService()
    {
        return $this->catalogService;
    }

    public function getPaginatorVars($stringify = false)
    {
        if (isset($_GET['nn'])) {
            $this->perPageAction();
        }
        $keys = array('n', 'p', 'o', 's');
        $paginatorVars = array();
        foreach ($keys as $key) {
            if (isset($_GET[$key])) {
                $paginatorVars[$key] = $_GET[$key];
            }
        }

        return $paginatorVars;
    }

    public function perPageAction()
    {
        $keys = array('o', 's');
        foreach ($keys as $key) {
            if (isset($_GET[$key])) {
                $paginatorVars[$key] = $_GET[$key];
            }
        }

        $page = (isset($_GET['p']) ? $_GET['p'] : 1);
        $perPage = (isset($_GET['n']) ? $_GET['n'] : 10);

        $offset = ((($page * $perPage) - $perPage) + 1); //this is the first item on the page

        $paginatorVars['p'] = floor($offset / $_GET['nn']) + 1; //new page number
        $paginatorVars['n'] = $_GET['nn'];                      //new items per page

        $query = '?' . http_build_query($paginatorVars);

        return $this->redirect()->toUrl('/category/' . $this->params('id') . $query);
    }
}
