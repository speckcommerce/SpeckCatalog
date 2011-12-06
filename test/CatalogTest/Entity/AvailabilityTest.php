<?php
namespace SwmBaseTest\Entity;
use PHPUnit_Framework_TestCase,
    SwmBase\Entity\Availability,
    SwmBase\Entity\Company,
    SwmBase\Entity\Product,
    SwmBase\Entity\ProductUom,
    InvalidArgumentException,
    RuntimeException;

class AvailabilityTest extends PHPUnit_Framework_TestCase     
{
    


    public function testScalarSettersAndGetters()
    {
        $availability = new Availability;
        $availability->setAvailabilityId(10)
                     ->setQuantity(1)
                     ->setCost(10.01);

        $this->assertSame(10, $availability->getAvailabilityId());
        $this->assertSame(1, $availability->getQuantity());
        $this->assertSame(10.01, $availability->getCost());
    }
    
    public function testObjectSettersAndGetters()
    {
        $availability = new Availability;
        $company = new Company;
        $product = new Product;
        $productUom = new ProductUom;
        $availability->setDistributor($company)
                     ->setProduct($product)
                     ->setProductUom($productUom);
        
        $this->assertSame($company,$availability->getDistributor()); 
        $this->assertSame($product,$availability->getProduct()); 
        $this->assertSame($productUom,$availability->getProductUom()); 
    }
    
}
