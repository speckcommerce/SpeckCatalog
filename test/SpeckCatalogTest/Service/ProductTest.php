<?php

namespace SpeckCatalogTest\Service;

use PHPUnit\Extensions\Database\TestCase;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    public function testUpdateGetsValuesFromDataForOriginalValsFromArray()
    {
        $data = array('product_id' => 1);
        $mockMapper = $this->getMock('\SpeckCatalog\Mapper\AbstractMapper');
        $mockMapper->expects($this->once())
            ->method('update')
            ->with($data, $data);
        $service = $this->getService();
        $service->setEntityMapper($mockMapper);
        $service->update($data, null);
    }

    public function testUpdateGetsValuesFromDataForOriginalValsFromProduct()
    {
        $data = array('product_id' => 97);
        $product = new \SpeckCatalog\Model\Product();
        $product->setProductId(97);
        $mockMapper = $this->getMock('\SpeckCatalog\Mapper\AbstractMapper');
        $mockMapper->expects($this->once())
            ->method('update')
            ->with($product, $data);
        $service = $this->getService();
        $service->setEntityMapper($mockMapper);
        $service->update($product, null);
    }

    public function getService()
    {
        return new \SpeckCatalog\Service\Product();
    }

    public function testPopulatePopulatesProduct()
    {
        $service = $this->getService();

        $optionService = $this->getMock('\SpeckCatalog\Service\Option');
        $optionService->expects($this->once())
            ->method('getByProductId')
            ->will($this->returnValue(array(new \SpeckCatalog\Model\Option\Relational)));
        $service->setOptionService($optionService);

        $imageService = $this->getMock('\SpeckCatalog\Service\Image');
        $imageService->expects($this->once())
            ->method('getImages')
            ->will($this->returnValue(array(new \SpeckCatalog\Model\ProductImage\Relational)));
        $service->setImageService($imageService);

        $documentService = $this->getMock('\SpeckCatalog\Service\Document');
        $documentService->expects($this->once())
            ->method('getDocuments')
            ->will($this->returnValue(array(new \SpeckCatalog\Model\Document\Relational)));
        $service->setDocumentService($documentService);

        $productUomService = $this->getMock('\SpeckCatalog\Service\ProductUom');
        $productUomService->expects($this->once())
            ->method('getByProductId')
            ->will($this->returnValue(array(new \SpeckCatalog\Model\ProductUom\Relational)));
        $service->setProductUomService($productUomService);

        $specService = $this->getMock('\SpeckCatalog\Service\Spec');
        $specService->expects($this->once())
            ->method('getByProductId')
            ->will($this->returnValue(array(new \SpeckCatalog\Model\Spec\Relational)));
        $service->setSpecService($specService);

        $companyService = $this->getMock('\SpeckCatalog\Service\Company');
        $companyService->expects($this->once())
            ->method('findById')
            ->will($this->returnValue(new \SpeckCatalog\Model\Company\Relational));
        $service->setCompanyService($companyService);

        $product = new \SpeckCatalog\Model\Product\Relational;
        $product->setProductId('111');
        $service->populate($product);

        $options = $product->getOptions();
        $this->assertTrue(is_array($options));
        $this->assertTrue(count($options) === 1);

        $images = $product->getImages();
        $this->assertTrue(is_array($images));
        $this->assertTrue(count($images) === 1);

        $documents = $product->getDocuments();
        $this->assertTrue(is_array($documents));
        $this->assertTrue(count($documents) === 1);

        $uoms = $product->getUoms();
        $this->assertTrue(is_array($uoms));
        $this->assertTrue(count($uoms) === 1);

        $specs = $product->getSpecs();
        $this->assertTrue(is_array($specs));
        $this->assertTrue(count($specs) === 1);

        $manufacturer = $product->getManufacturer();
        $this->assertInstanceOf('\SpeckCatalog\Model\Company', $manufacturer);
    }

    public function testAddOptionWithModelsCallsAddOptionAndReturnsOption()
    {
        $mockMapper = $this->getMock('\SpeckCatalog\Mapper\Product');
        $mockMapper->expects($this->once())
            ->method('addOption')
            ->with(1, 2);
        $mockOptionService = $this->getMock('\SpeckCatalog\Service\Option');
        $mockOptionService->expects($this->once())
            ->method('find')
            ->with(array('option_id' => 2))
            ->will($this->returnValue(new \SpeckCatalog\Model\Option));

        $service = $this->getService();
        $service->setEntityMapper($mockMapper);
        $service->setOptionService($mockOptionService);

        $return = $service->addOption(1, 2);
        $this->assertInstanceOf('\SpeckCatalog\Model\Option', $return);
    }


    public function testAddOptionWithIdsCallsAddOptionAndReturnsOption()
    {
        $mockMapper = $this->getMock('\SpeckCatalog\Mapper\Product');
        $mockMapper->expects($this->once())
            ->method('addOption')
            ->with(1, 2);
        $mockOptionService = $this->getMock('\SpeckCatalog\Service\Option');
        $mockOptionService->expects($this->once())
            ->method('find')
            ->with(array('option_id' => 2))
            ->will($this->returnValue(new \SpeckCatalog\Model\Option));

        $service = $this->getService();
        $service->setEntityMapper($mockMapper);
        $service->setOptionService($mockOptionService);

        $product = new \SpeckCatalog\Model\Product();
        $product->setProductId(1);
        $option = new \SpeckCatalog\Model\Option();
        $option->setOptionId(2);
        $return = $service->addOption($product, $option);
        $this->assertInstanceOf('\SpeckCatalog\Model\Option', $return);
    }

}
