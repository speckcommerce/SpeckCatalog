<?php
namespace SwmBaseTest\Entity;
use PHPUnit_Framework_TestCase,
    SwmBase\Entity\Choice,
    SwmBase\Entity\Shell,
    SwmBase\Entity\ProductUom,
    InvalidArgumentException,
    RuntimeException;

class ChoiceTest extends PHPUnit_Framework_TestCase     
{
    public function testScalarSettersAndGetters()
    {
        $choice = new Choice;
        $choice->setName('somename')
               ->setTargetUomDiscount(10.00)
               ->setAllUomsDiscount(5.00);


        $this->assertSame(10.00, $choice->getTargetUomDiscount());
        $this->assertSame(5.00, $choice->getAllUomsDiscount());
        $this->assertSame('somename', $choice->getName());
    }
    
    public function testObjectSettersAndGetters()
    {
        $choice = new choice;
        $shell = new Shell('shell');
        $uom = new ProductUom;
        $choice->setShell($shell)
               ->setTargetUom($uom);

        $this->assertSame($shell, $choice->getShell());
        $this->assertSame($uom, $choice->getTargetUom());
    }
    
}
