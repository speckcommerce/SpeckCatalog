<?php

namespace SpeckCatalogTest\Service;

use PHPUnit\Extensions\Database\TestCase;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    public function testFind()
    {
        $product = new \SpeckCatalog\Model\Product;

        $service = $this->getMock('\SpeckCatalog\Service\Product', ['populate']);
        $service->expects($this->atLeastOnce())
            ->method('populate')
            ->with($product)
            ->will($this->returnValue($product));
        $mockMapper = $this->getMock('\SpeckCatalog\Mapper\Product');
        $mockMapper->expects($this->once())
            ->method('find')
            ->with(['product_id' => 321])
            ->will($this->returnValue($product));
        $service->setEntityMapper($mockMapper);

        $return = $service->find(['product_id' => 321], true);
        $this->assertInstanceOf('\SpeckCatalog\Model\Product', $return);
    }

    public function testGetFullProduct()
    {
        $product = new \SpeckCatalog\Model\Product;

        $service = $this->getMock('\SpeckCatalog\Service\Product', ['find', 'populate']);
        $service->expects($this->once())
            ->method('populate')
            ->with($product)
            ->will($this->returnValue($product));
        $service->expects($this->once())
            ->method('find')
            ->with(['product_id' => 4321])
            ->will($this->returnValue($product));

        $return = $service->getFullProduct(4321);
        $this->assertInstanceOf('\SpeckCatalog\Model\Product', $return);
    }

    public function testUpdateGetsValuesFromDataForOriginalValsFromArray()
    {
        $data = ['product_id' => 1];
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
        $data = ['product_id' => 97];
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
        $this->markTestIncomplete('Tests was broken/obsoleted');
        $service = $this->getService();

        $optionService = $this->getMock('\SpeckCatalog\Service\Option');
        $optionService->expects($this->once())
            ->method('getByProductId')
            ->will($this->returnValue([new \SpeckCatalog\Model\Option\Relational]));
        $service->setOptionService($optionService);

        $imageService = $this->getMock('\SpeckCatalog\Service\Image');
        $imageService->expects($this->once())
            ->method('getImages')
            ->will($this->returnValue([new \SpeckCatalog\Model\ProductImage\Relational]));
        $service->setImageService($imageService);

        $documentService = $this->getMock('\SpeckCatalog\Service\Document');
        $documentService->expects($this->once())
            ->method('getDocuments')
            ->will($this->returnValue([new \SpeckCatalog\Model\Document\Relational]));
        $service->setDocumentService($documentService);

        $productUomService = $this->getMock('\SpeckCatalog\Service\ProductUom');
        $productUomService->expects($this->once())
            ->method('getByProductId')
            ->will($this->returnValue([new \SpeckCatalog\Model\ProductUom\Relational]));
        $service->setProductUomService($productUomService);

        $specService = $this->getMock('\SpeckCatalog\Service\Spec');
        $specService->expects($this->once())
            ->method('getByProductId')
            ->will($this->returnValue([new \SpeckCatalog\Model\Spec\Relational]));
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
            ->with(['option_id' => 2])
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
            ->with(['option_id' => 2])
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

    public function testSortOptionsCallsSortOptionsOnMapper()
    {
        $mockMapper = $this->getMock('\SpeckCatalog\Mapper\Product');
        $mockMapper->expects($this->once())
            ->method('sortOptions')
            ->with(1, [1,2]);
        $service = $this->getService();
        $service->setEntityMapper($mockMapper);
        $service->sortOptions(1, [1,2]);
    }

    public function testRemoveOptionCallsRemoveOptionOnMapper()
    {
        $mockMapper = $this->getMock('\SpeckCatalog\Mapper\Product');
        $mockMapper->expects($this->once())
            ->method('removeOption')
            ->with(1, 2);
        $service = $this->getService();
        $service->setEntityMapper($mockMapper);
        $service->removeOption(['product_id' => 1], ['option_id' => 2]);
    }

    public function testInsertCallsInsertAndReturnsNewProduct()
    {
        $product = new \SpeckCatalog\Model\Product;
        $mockMapper = $this->getMock('\SpeckCatalog\Mapper\Product');
        $mockMapper->expects($this->once())
            ->method('insert')
            ->with($product)
            ->will($this->returnValue(1));
        $mockMapper->expects($this->once())
            ->method('find')
            ->will($this->returnValue(new \SpeckCatalog\Model\Product));

        $service = $this->getService();
        $service->setEntityMapper($mockMapper);
        $return = $service->insert($product);
        $this->assertInstanceOf('\SpeckCatalog\Model\Product', $return);
    }

    public function testGetByCategoryIdSetsPaginatorAndCallsGetByCategoryIdOnMapper()
    {
        $mockMapper = $this->getMock('\SpeckCatalog\Mapper\Product');
        $mockMapper->expects($this->once())
            ->method('usePaginator');
        $mockMapper->expects($this->once())
            ->method('getByCategoryId')
            ->with(1);

        $service = $this->getService();
        $service->setEntityMapper($mockMapper);
        $return = $service->getByCategoryId(1);
    }

    public function testPopulateForPricingPopulatesRecursiveOptionsAndProductUoms()
    {
        //method not implemented yet
    }

    public function testGetOptionService()
    {
        $service = $this->getService();
        $service->setOptionService($this->getMock('\SpeckCatalog\Service\Option'));
        $return = $service->getOptionService();
        $this->assertInstanceOf('\SpeckCatalog\Service\Option', $return);
    }

    public function testGetOptionServiceGetsOptionServiceFromServiceManager()
    {
        $service = $this->getService();
        $mockServiceManager = $this->getMock('\Zend\ServiceManager\ServiceManager');
        $mockServiceManager->expects($this->once())
            ->method('get')
            ->with('speckcatalog_option_service')
            ->will($this->returnValue(new \SpeckCatalog\Service\Option));

        $service->setServiceLocator($mockServiceManager);
        $service->getOptionService();
    }

    public function testGetProductUomService()
    {
        $service = $this->getService();
        $service->setProductUomService($this->getMock('\SpeckCatalog\Service\ProductUom'));
        $return = $service->getProductUomService();
        $this->assertInstanceOf('\SpeckCatalog\Service\ProductUom', $return);
    }

    public function testGetProductUomServiceGetsProductUomServiceFromServiceManager()
    {
        $service = $this->getService();
        $mockServiceManager = $this->getMock('\Zend\ServiceManager\ServiceManager');
        $mockServiceManager->expects($this->once())
            ->method('get')
            ->with('speckcatalog_product_uom_service')
            ->will($this->returnValue(new \SpeckCatalog\Service\ProductUom));

        $service->setServiceLocator($mockServiceManager);
        $service->getProductUomService();
    }

    public function testGetImageService()
    {
        $service = $this->getService();
        $service->setImageService($this->getMock('\SpeckCatalog\Service\Image'));
        $return = $service->getImageService();
        $this->assertInstanceOf('\SpeckCatalog\Service\Image', $return);
    }

    public function testGetImageServiceGetsImageServiceFromServiceManager()
    {
        $service = $this->getService();
        $mockServiceManager = $this->getMock('\Zend\ServiceManager\ServiceManager');
        $mockServiceManager->expects($this->once())
            ->method('get')
            ->with('speckcatalog_product_image_service')
            ->will($this->returnValue(new \SpeckCatalog\Service\Image));

        $service->setServiceLocator($mockServiceManager);
        $service->getImageService();
    }

    public function testGetDocumentService()
    {
        $service = $this->getService();
        $service->setDocumentService($this->getMock('\SpeckCatalog\Service\Document'));
        $return = $service->getDocumentService();
        $this->assertInstanceOf('\SpeckCatalog\Service\Document', $return);
    }

    public function testGetDocumentServiceGetsImageServiceFromServiceManager()
    {
        $service = $this->getService();
        $mockServiceManager = $this->getMock('\Zend\ServiceManager\ServiceManager');
        $mockServiceManager->expects($this->once())
            ->method('get')
            ->with('speckcatalog_document_service')
            ->will($this->returnValue(new \SpeckCatalog\Service\Document));

        $service->setServiceLocator($mockServiceManager);
        $service->getDocumentService();
    }

    public function testGetSpecService()
    {
        $service = $this->getService();
        $service->setSpecService($this->getMock('\SpeckCatalog\Service\Spec'));
        $return = $service->getSpecService();
        $this->assertInstanceOf('\SpeckCatalog\Service\Spec', $return);
    }

    public function testGetSpecServiceGetsImageServiceFromServiceManager()
    {
        $service = $this->getService();
        $mockServiceManager = $this->getMock('\Zend\ServiceManager\ServiceManager');
        $mockServiceManager->expects($this->once())
            ->method('get')
            ->with('speckcatalog_spec_service')
            ->will($this->returnValue(new \SpeckCatalog\Service\Spec));

        $service->setServiceLocator($mockServiceManager);
        $service->getSpecService();
    }

    public function testGetCompanyService()
    {
        $service = $this->getService();
        $service->setCompanyService($this->getMock('\SpeckCatalog\Service\Company'));
        $return = $service->getCompanyService();
        $this->assertInstanceOf('\SpeckCatalog\Service\Company', $return);
    }

    public function testGetCompanyServiceGetsImageServiceFromServiceManager()
    {
        $service = $this->getService();
        $mockServiceManager = $this->getMock('\Zend\ServiceManager\ServiceManager');
        $mockServiceManager->expects($this->once())
            ->method('get')
            ->with('speckcatalog_company_service')
            ->will($this->returnValue(new \SpeckCatalog\Service\Company));

        $service->setServiceLocator($mockServiceManager);
        $service->getCompanyService();
    }
}
