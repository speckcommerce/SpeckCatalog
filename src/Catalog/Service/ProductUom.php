<?php

namespace Catalog\Service;

class ProductUom extends AbstractService
{
    protected $entityMapper = 'catalog_product_uom_mapper';
    protected $availabilityService;
    protected $uomService;

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
        $uom = $this->getUomService()->find(array('uom_code' => $productUom->getUomCode()));
        $productUom->setUom($uom);
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

    /**
     * @return uomService
     */
    public function getUomService()
    {
        if (null === $this->uomService) {
            $this->uomService = $this->getServiceLocator()->get('catalog_uom_service');
        }
        return $this->uomService;
    }

    /**
     * @param $uomService
     * @return self
     */
    public function setUomService($uomService)
    {
        $this->uomService = $uomService;
        return $this;
    }
}
