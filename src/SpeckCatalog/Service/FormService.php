<?php

namespace SpeckCatalog\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use \Zend\ServiceManager\ServiceLocatorInterface;
use SpeckCatalog\Model\AbstractModel;

class FormService implements ServiceLocatorAwareInterface
{
    protected $serviceLocator;

    public function getForm($name = null, $model = null, $data = null)
    {
        $form = $this->formFromServiceManager($name);
        $filter = $this->filterFromServiceManager($name);
        $form->setInputFilter($filter);

        if ($model !== null) {
            $form->bind($model);
        }
        if (is_array($data)) {
            $form->setData($data);
        }

        return $form;
    }

    public function formFromServiceManager($name)
    {
        $formName = 'speckcatalog_' . $name . '_form';
        return $this->getServiceLocator()->get($formName);
    }

    public function filterFromServiceManager($name)
    {
        $filterName = 'speckcatalog_' . $name . '_form_filter';
        return $this->getServiceLocator()->get($filterName);
    }

    public function getKeyFields($name, $model = null, $parentKeyFields = false)
    {
        $form = $this->formFromServiceManager($name);

        $fields = array();

        if ($model) {
            foreach ($form->getOriginalFields() as $field) {
                $getter = 'get' . $this->camel($field);
                $fields[$field] = $model->$getter();
            }
        }

        return $fields;
    }

    protected function camel($name)
    {
        $camel = new \Zend\Filter\Word\UnderscoreToCamelCase;
        return $camel->__invoke($name);
    }

    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }
}
