<?php

namespace SpeckCatalogTest\Service;

use PHPUnit\Extensions\Database\TestCase;

class FormServiceTest extends \PHPUnit_Framework_TestCase
{

    public function getService()
    {
        return new \SpeckCatalog\Service\FormService();
    }

    public function testGetFormGetsFormAndFiterFromServiceAndReturnsForm()
    {
        $service = $this->getService();
        $mockSM = $this->getMock('\Zend\ServiceManager\ServiceLocatorInterface');
        $service->setServiceLocator($mockSM);

        $mockSM->expects($this->at(0))
            ->method('get')
            ->with('speckcatalog_product_form')
            ->will($this->returnValue(new \Zend\Form\Form));
        $mockSM->expects($this->at(1))
            ->method('get')
            ->with('speckcatalog_product_form_filter')
            ->will($this->returnValue(new \Zend\InputFilter\InputFilter));

        $return = $service->getForm('product');
        $this->assertInstanceOf('\Zend\Form\Form', $return);
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
