<?php

namespace SpeckCatalog\Service;

use SpeckCatalog\Model\AbstractModel;

class ProductUom extends AbstractService
{
    protected $entityMapper = 'speckcatalog_product_uom_mapper';
    protected $availabilityService;
    protected $uomService;
    protected $productService;

    public function getByProductId($productId, $populate = false, $recursive = false)
    {
        $productUoms = $this->getEntityMapper()->getByProductId($productId);
        if ($populate) {
            foreach ($productUoms as $productUom) {
                $this->populate($productUom, $recursive);
            }
        }
        return $productUoms;
    }

    public function cheapestUom(array $uoms)
    {
        $lowest = null;
        foreach ($uoms as $uom) {
            if (!$lowest) {
                $lowest = $uom;
            }
            if ($uom->getPrice() < $lowest->getPrice()) {
                $lowest = $uom;
            }
        }

        return $lowest;
    }

    public function populate($productUom, $recursive = false, $children = true)
    {
        $allChildren = ($children === true) ? true : false;
        $children    = (is_array($children)) ? $children : array();

        if ($allChildren || in_array('availabilities', $children)) {
            $availabilities = $this->getAvailabilityService()->getByProductUom(
                $productUom->getProductId(),
                $productUom->getUomCode(),
                $productUom->getQuantity()
            );
            if ($recursive) {
                foreach ($availabilities as $i => $avail) {
                    $this->getAvailabilityService()->populate($avail);
                }
            }
            $productUom->setAvailabilities($availabilities);
        }
        if ($allChildren || in_array('uom', $children)) {
            $uom = $this->getUomService()->find(array('uom_code' => $productUom->getUomCode()));
            $productUom->setUom($uom);
        }
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

    public function update($data, array $where = null)
    {
        $vars = array(
            'data'        => $data,
            'where'       => $where,
        );

        $this->getEventManager()->trigger('update.pre', $this, $vars);

        $result = parent::update($data, $where);
        $vars['result'] = $result;

        $this->getEventManager()->trigger('update.post', $this, $vars);

        return $result;
    }

    public function insert($productUom)
    {
        if ($productUom instanceof AbstractModel) {
            $data = array(
                'uom_code' => $productUom->getUomCode(),
                'product_id' => $productUom->getProductId(),
                'quantity' => $productUom->getQuantity(),
            );
        } elseif (is_array($productUom)) {
            $data = $productUom;
        }

        $vars = array(
            'data' => $data,
        );
        $this->getEventManager()->trigger('insert.pre', $this, $vars);

        $vars['result'] = parent::insert($productUom);

        $this->getEventManager()->trigger('insert.post', $this, $vars);

        $productUom = $this->find($data);
        return $productUom;
    }

    /**
     * @return productService
     */
    public function getProductService()
    {
        if (null === $this->productService) {
            $this->productService = $this->getServiceLocator()->get('speckcatalog_product_service');
        }
        return $this->productService;
    }

    /**
     * @param $productService
     * @return self
     */
    public function setProductService($productService)
    {
        $this->productService = $productService;
        return $this;
    }
}
