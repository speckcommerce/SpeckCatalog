<?php

namespace Catalog\Model\Product;

use Catalog\Model\Product as Base;

class Relational extends Base
{
    protected $manufacturer;
    protected $options;
    protected $uoms;
    protected $images;
    protected $specs;
    protected $documents;
    protected $features;

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

    public function getImage()
    {
        if (isset($this->images[0])) {
            return $this->images[0];
        }
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

    /**
     * @return images
     */
    public function getImages()
    {
        return $this->images;
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

    /**
     * @return features
     */
    public function getFeatures()
    {
        return $this->features;
    }

    /**
     * @param $features
     * @return self
     */
    public function setFeatures($features)
    {
        $this->features = $features;
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
     * @return manufacturer
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * @param $manufacturer
     * @return self
     */
    public function setManufacturer($manufacturer)
    {
        $this->manufacturer = $manufacturer;
        return $this;
    }

    public function __toString()
    {
        $name = $this->getName();
        $parent = parent::__toString();
        return ($name ?: $parent);
    }
}
