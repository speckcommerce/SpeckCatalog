<?php
namespace SwmBaseTest\Entity;
use PHPUnit_Framework_TestCase,
    SwmBase\Entity\Shell,
    SwmBase\Entity\Product,
    SwmBase\Entity\Option,
    SwmBase\Entity\ProductUom,
    InvalidArgumentException,
    RuntimeException;

class ShellTest extends PHPUnit_Framework_TestCase     
{
    public function testShellSetAllValidTypes()
    {
        $shell = new Shell('product');
        $this->assertSame('product', $shell->getType());
        $shell = new Shell('shell');
        $this->assertSame('shell', $shell->getType());
        $shell = new Shell('builder');
        $this->assertSame('builder', $shell->getType());
    } 
    
    public function testNotPassingTypeAtConstructThrowsException()
    {
        $this->setExpectedException('RuntimeException');
        $shell = new Shell;
    }

    public function testPassingInvalidTypeAtConstructThrowsException()
    {
        $this->setExpectedException('InvalidArgumentException');
        $shell = new Shell('oranges!');
    }
    
    public function testPassingNonFloatPriceThrowsException()
    {
        $this->setExpectedException('InvalidArgumentException');
        $shell = new Shell('shell');
        $shell->setPrice(10);
    }
    
    public function testSetProductWhenTypeNotProductThrowsException()
    {
        $this->setExpectedException('RuntimeException');
        $shell = new Shell('shell');
        $shell->setProduct(new Product);
    }
    
    public function testScalarSettersAndGetters()
    {
        $shell = new Shell('shell');
        $shell->setName('somename')
              ->setDescription('another string!')
              ->setShellId(10)
              ->setPrice(21.99);

        $this->assertSame('shell', $shell->getType());
        $this->assertSame('somename', $shell->getName());
        $this->assertSame('another string!', $shell->getDescription());
        $this->assertSame(10, $shell->getShellId());
        $this->assertSame(21.99, $shell->getPrice());
    }
    
    public function testObjectSettersAndGetters()
    {
        $shell = new Shell('product');
        $product = new Product;
        $option = new Option('radio');
        $shell->setProduct($product)
              ->setOptions(array($option))
              ->addOption($option);
        $this->assertSame($product, $shell->getProduct());

        $returnedOptions = $shell->getOptions();
        $this->assertSame(2,count($returnedOptions));
        $this->assertSame($option,$returnedOptions[0]); 
    }
}
