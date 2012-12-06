<?php

namespace SpeckCatalogTest\View\Helper;

use SpeckCatalog\View\Helper\AdderHelper;

class AdderHelperTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->view = $this->getMock(
            'Zend\\View\\Renderer\\PhpRenderer',
            array('render')
        );

        $this->helper = new AdderHelper;
        $this->helper->setView($this->view);

        $this->partial = '/assert/partial/dir/';
        $this->helper->setPartialDir($this->partial);
    }

    public function testGetPartialDir()
    {
        $this->assertEquals($this->partial, $this->helper->getPartialDir());
    }

    public function testAddNewReturnsRenderedData()
    {
        $html = '<p>some rendered html</p>';
        $this->view->expects($this->once())
            ->method('render')
            ->will($this->returnValue($html));

        $this->assertEquals(
            $html,
            $this->helper->addNew('spec', 'product', array())
        );
    }

    public function testAddNewProvidesFormToPartial()
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

    public function testRemoveChildReturnsRenderedData()
    {
        $html = '<p>some rendered html</p>';
        $this->view->expects($this->once())
            ->method('render')
            ->will($this->returnValue($html));

        $this->assertEquals(
            $html,
            $this->helper->removeChild('parentName', array(), 'childName', array())
        );
    }

    public function testRemoveChildProvidesFormToPartial()
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
