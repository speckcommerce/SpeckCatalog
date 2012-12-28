<?php

namespace SpeckCatalogTest\Service;

use PHPUnit\Extensions\Database\TestCase;

class FormServiceTest extends \PHPUnit_Framework_TestCase
{

    public function getService()
    {
        return new \SpeckCatalog\Service\FormService();
    }

    public function testGetFormReturnsFormModel()
    {

        $service = $this->getService();
        $serviceManager = $this->getServiceManager();
        $service->setServiceLocator($serviceManager);
        $return = $service->getForm('product');
        $this->assertInstance('\Zend\Form\Form');
    }

    public function testGetFormWithObjectModelBindsObjectModel()
    {
    }

    public function testGetFormWithDataArrayCallsSetsFormData()
    {
    }

    public function testGetKeyFieldsReturnsFieldsMatchingOriginalFieldsInFormObject()
    {
    }

    public function testGetKeyFieldsReturnsArrayOfFieldsAndValues()
    {
    }

    public function getServiceManager()
    {
        return \SpeckCatalogTest\Bootstrap::getServiceManager();
    }
}
