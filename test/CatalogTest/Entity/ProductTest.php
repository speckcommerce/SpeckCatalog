<?php
namespace SwmBaseTest\Entity;
use PHPUnit_Framework_TestCase,
    SwmBase\Entity\Product,
    SwmBase\Entity\Company,
    SwmBase\Entity\ProductUom,
    InvalidArgumentException,
    RuntimeException;

class ProductTest extends PHPUnit_Framework_TestCase     
{

    
    public function testScalarSettersAndGetters()
    {
        $product = new Product;
        $product->setProductId(10)
                ->setName('somename')
                ->setHcpcs('ASDF1234')
                ->setPartNumber('1234ASDF');

        $this->assertSame(10, $product->getProductId());
        $this->assertSame('somename', $product->getName());
        $this->assertSame('ASDF1234', $product->getHcpcs());
        $this->assertSame('1234ASDF', $product->getPartNumber());
    }
    
    public function testObjectSettersAndGetters()
    {
        $product = new Product;
        
        $manufacturer = new Company;
        $uom = new ProductUom;
        $uoms = array($uom);

        $product->setManufacturer($manufacturer)
              ->setUoms($uoms);
        
        $this->assertSame($manufacturer, $product->getManufacturer());

        $returnedUoms = $product->getUoms();
        $this->assertSame(1,count($returnedUoms));
        $this->assertSame($uom,$returnedUoms[0]); 
    }
    
}
