<?php

namespace SpeckCatalog\Service;

use SpeckCatalog\Model\AbstractModel;

class ProductUom extends AbstractService
{
    protected $entityMapper = 'speckcatalog_product_uom_mapper';
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

    public function populate($productUom, $recursive=false)
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
            $this->availabilityService = $this->getServiceLocator()->get('speckcatalog_availability_service');
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
            $this->uomService = $this->getServiceLocator()->get('speckcatalog_uom_service');
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

    public function insert($productUom)
    {
        if($productUom instanceOf AbstractModel) {
            $data = array(
                'uom_code' => $productUom->getUomCode(),
                'product_id' => $productUom->getProductId(),
                'quantity' => $productUom->getQuantity(),
            );
        } elseif (is_array($productUom)) {
            $data = $productUom;
        }

        parent::insert($productUom);

        $productUom = $this->find($data);
        return $productUom;
    }
}
