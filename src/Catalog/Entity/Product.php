<?php

namespace Catalog\Entity;

class Product extends AbstractEntity
{
    protected $productId;
    protected $name;
    protected $description;
    protected $productTypeId = 1;
    protected $itemNumber;
    protected $manufacturerId;

    //non db fields
    protected $options;
    protected $specs;
    protected $images;
    protected $documents;
    protected $uoms;

    /**
     * @return productId
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @param $productId
     * @return self
     */
    public function setProductId($productId)
    {
        $this->productId = (int) $productId;
        return $this;
    }

    /**
     * @return name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param $description
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return productTypeId
     */
    public function getProductTypeId()
    {
        return $this->productTypeId;
    }

    /**
     * @param $productTypeId
     * @return self
     */
    public function setProductTypeId($productTypeId)
    {
        $this->productTypeId = (int) $productTypeId;
        return $this;
    }

    /**
     * @return itemNumber
     */
    public function getItemNumber()
    {
        return $this->itemNumber;
    }

    /**
     * @param $itemNumber
     * @return self
     */
    public function setItemNumber($itemNumber)
    {
        $this->itemNumber = $itemNumber;
        return $this;
    }

    /**
     * @return manufacturerId
     */
    public function getManufacturerId()
    {
        return $this->manufacturerId;
    }

    /**
     * @param $manufacturerId
     * @return self
     */
    public function setManufacturerId($manufacturerId)
    {
        $this->manufacturerId = (int) $manufacturerId;
        return $this;
    }

    /**
     * @return options
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param $options
     * @return self
     */
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return specs
     */
    public function getSpecs()
    {
        return $this->specs;
    }

    /**
     * @param $specs
     * @return self
     */
    public function setSpecs($specs)
    {
        $this->specs = $specs;
        return $this;
    }

    /**
     * @return images
     */
    public function getImages()
    {
        return $this->images;
    }

    public function getImage()
    {
        if (isset($this->images[0])) {
            return $this->images[0];
        }
    }

    /**
     * @param $images
     * @return self
     */
    public function setImages($images)
    {
        $this->images = $images;
        return $this;
    }

    /**
     * @return documents
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * @param $documents
     * @return self
     */
    public function setDocuments($documents)
    {
        $this->documents = $documents;
        return $this;
    }

    public function __toString()
    {
        return '' . $this->getName();
    }

    public function getRecursivePrice($uomCode = null)
    {
        $price = 0;
        if ($this->has('options')) {
            foreach ($this->getOptions() as $option) {
                $price = $price + $option->getRecursivePrice();
            }
        }
        if ($this->has('uoms')) {
            $uomPrices = array();
            foreach($this->getUoms() as $uom) {
                $uomPrices[] = $uom->getPrice();
            }
            asort($uomPrices);
            $price = $price + array_shift($uomPrices);
        }
        return $price;
    }

    public function getPrice()
    {
        if ($this->has('uoms')) {
            $uomPrices = array();
            foreach($this->getUoms() as $uom) {
                $uomPrices[] = $uom->getPrice();
            }
            asort($uomPrices);
            return array_shift($uomPrices);
        }
        return 0;
    }

    /**
     * @return uoms
     */
    public function getUoms()
    {
        return $this->uoms;
    }

    /**
     * @param $uoms
     * @return self
     */
    public function setUoms($uoms)
    {
        $this->uoms = $uoms;
        return $this;
    }
}
