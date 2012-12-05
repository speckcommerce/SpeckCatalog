<?php

namespace SpeckCatalogTest\View\Helper;

use SpeckCatalog\View\Helper\AdderHelper;

class AdderHelperTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $viewMock = $this->getMock(
            'Zend\\View\\Renderer\\PhpRenderer',
            array('render')
        );

        $helper = new AdderHelper;
        $helper->setView($viewMock);

        $partial = '/assert/partial/dir/';
        $helper->setPartialDir($partial);

        $this->helper  = $helper;
        $this->partial = $partial;
        $this->view    = $viewMock;
    }

    public function testGetPartialDir()
    {
        $this->assertEquals($this->partial, $this->helper->getPartialDir());
    }

    public function testAddNew()
    {
        $form = null;
        $callback = function($partial, $params) use (&$form) {
            $form = $params['addForm'];
        };
        $this->view->expects($this->once())
            ->method('render')
            ->with($this->equalTo($this->partial . 'add'), $this->arrayHasKey('addForm'))
            ->will($this->returnCallback($callback));

        $this->helper->addNew('spec', 'product', array());

        $this->assertInstanceOf('SpeckCatalog\\Form\\AddChild', $form);
    }

    public function testRemoveChild()
    {
        $form = null;
        $callback = function($partial, $params) use (&$form) {
            $form = $params['removeForm'];
        };
        $this->view->expects($this->once())
            ->method('render')
            ->with($this->equalTo($this->partial . 'remove'), $this->arrayHasKey('removeForm'))
            ->will($this->returnCallback($callback));

        $this->helper->removeChild('parentName', array(), 'childName', array());

        $this->assertInstanceOf('SpeckCatalog\\Form\\RemoveChild', $form);
    }
}
