<?php

namespace Catalog\Service;

class ProductUom extends AbstractService
{
    protected $entityMapper = 'catalog_product_uom_mapper';
    protected $availabilityService;

    public function find($productId, $uomCode, $quantity)
    {
        return $this->getEntityMapper()->find($productId, $uomCode, $quantity);
    }

    public function getByProductId($productId, $populate=false, $recursive=false)
    {
        $productUoms = $this->getEntityMapper()->getByProductId($productId);
        if ($populate) {
            foreach ($productUoms as $productUom) {
                $this->populate($productUom, $recursive);
            }
        }
        return $productUoms;
    }

    public function populate($productUom)
    {
        $availabilities = $this->getAvailabilityService()->getByProductUom(
            $productUom->getProductId(),
            $productUom->getUomCode(),
            $productUom->getQuantity()
        );
        $productUom->setAvailabilities($availabilities);
    }

    /**
     * @return availabilityService
     */
    public function getAvailabilityService()
    {
        if (null === $this->availabilityService) {
            $this->availabilityService = $this->getServiceLocator()->get('catalog_availability_service');
        }
        return $this->availabilityService;
    }

    /**
     * @param $availabilityService
     * @return self
     */
    public function setAvailabilityService($availabilityService)
    {
        $this->availabilityService = $availabilityService;
        return $this;
    }
}
