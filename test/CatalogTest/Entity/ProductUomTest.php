<?php
namespace SwmBaseTest\Entity;
use PHPUnit_Framework_TestCase,
    SwmBase\Entity\Availability,
    SwmBase\Entity\ProductUom,
    SwmBase\Entity\Product,
    InvalidArgumentException,
    RuntimeException;

class ProductUomTest extends PHPUnit_Framework_TestCase     
{

    public function testScalarSettersAndGetters()
    {
        $productUom = new ProductUom;
        $productUom->setProductUomId(10)
                ->setPrice(12.99)
                ->setQuantity(10)
                ->setRetail(15.99);

        $this->assertSame(10, $productUom->getProductUomId());
        $this->assertSame(12.99, $productUom->getPrice());
        $this->assertSame(10, $productUom->getQuantity());
        $this->assertSame(15.99, $productUom->getRetail());
    }
    
    public function testPassingNonFloatRetailThrowsException()
    {
        $this->setExpectedException('InvalidArgumentException');
        $uom = new ProductUom;
        $uom->setRetail(10);
    }
    public function testPassingNonFloatPriceThrowsException()
    {
        $this->setExpectedException('InvalidArgumentException');
        $uom = new ProductUom;
        $uom->setPrice(10);
    }
    
    public function testObjectSettersAndGetters()
    {
        $productUom = new ProductUom;
        $product = new Product;

        $availability = new Availability;

        $availabilities = array($availability);

        $productUom->setProduct($product)
            ->setAvailabilities($availabilities)
            ->addAvailability($availability);
        
        $this->assertSame($product, $productUom->getProduct());

        $returnedAvailabilities = $productUom->getAvailabilities();
        $this->assertSame(2,count($returnedAvailabilities));
        $this->assertSame($availability,$returnedAvailabilities[0]); 
    }
    
}
