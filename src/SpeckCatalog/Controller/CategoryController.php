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

        $id = $this->params('id');
        $category = $this->getServiceLocator()->get('speckcatalog_category_service')->getCategoryForView($id, $paginatorVars);
        if (null === $category) {
            throw new \Exception('fore oh fore');
        }
        $paginatorVars['categoryId'] = $category->getCategoryId();
        return new ViewModel(array(
            'category' => $category,
            'paginatorVars' => $paginatorVars,
            )
        );
    }

    function setCatalogService($catalogService)
    {
        $this->catalogService = $catalogService;
    }

    function getCatalogService()
    {
        return $this->catalogService;
    }

    function getPaginatorVars($stringify = false)
    {
        if(isset($_GET['nn'])) {
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

    function perPageAction()
    {
        $keys = array('o', 's');
        foreach ($keys as $key) {
            if(isset($_GET[$key])) {
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
