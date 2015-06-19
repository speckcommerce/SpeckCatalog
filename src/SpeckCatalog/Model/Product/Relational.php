<?php

namespace SpeckCatalog\Model\Product;

use SpeckCatalog\Model\AbstractModel;
use SpeckCatalog\Model\Product as Base;

class Relational extends Base
{
    protected $parent;
    protected $manufacturer;
    protected $options;
    protected $uoms;
    protected $images;
    protected $specs;
    protected $documents;
    protected $features;
    protected $builders;

    public function getKey()
    {
        return $this->productId;
    }

    public function getRecursivePrice($retailPrice = false)
    {
        $price = $this->getPrice($retailPrice);

        $adjustmentPrice = 0;
        if ($this->has('options')) {
            foreach ($this->getOptions() as $option) {
                $adjustmentPrice += $option->getRecursivePrice($price, $retailPrice);
            }
        }

        return $price + $adjustmentPrice;
    }

    public function type($type = null)
    {
        if ($type === 'shell') {
            $product->setProductTypeId(1);
        } elseif ($type === 'product') {
            $product->setProductTypeId(2);
        }
        switch($this->getProductTypeId()) {
            case 1:
                return 'shell';
                break;
            case 2:
                return 'product';
                break;
        }
    }


    public function getPrice($retailPrice = false)
    {
        if ($this->has('uoms')) {
            $uomPrices = array();
            foreach ($this->getUoms() as $uom) {
                $uomPrices[] = $retailPrice ? $uom->getRetail() : $uom->getPrice();
            }
            asort($uomPrices, SORT_NUMERIC);
            return array_shift($uomPrices);
        } elseif ($this->has('builders')) {
            $uomPrices = array();
            foreach ($this->getBuilders() as $builder) {
                foreach ($builder->getProduct()->getUoms() as $uom) {
                    $uomPrices[] = $retailPrice ? $uom->getRetail() : $uom->getPrice();
                }
            }
            asort($uomPrices, SORT_NUMERIC);
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

    public function addUom($uom)
    {
        $uom->setParent($this);
        $this->uoms[] = $uom;
        return $this;
    }

    /**
     * @param $uoms
     * @return self
     */
    public function setUoms($uoms)
    {
        $this->uoms = array();

        foreach ($uoms as $uom) {
            $this->addUom($uom);
        }

        return $this;
    }

    /**
     * @return images
     */
    public function getImages()
    {
        return $this->images;
    }

    public function addImage($image)
    {
        $image->setParent($this);
        $this->images[] = $image;
        return $this;
    }

    /**
     * @param $images
     * @return self
     */
    public function setImages($images)
    {
        $this->images = array();

        foreach ($images as $image) {
            $this->addImage($image);
        }

        return $this;
    }

    /**
     * @return specs
     */
    public function getSpecs()
    {
        return $this->specs;
    }

    public function addSpec($spec)
    {
        $spec->setParent($this);
        $this->specs[] = $spec;
        return $this;
    }

    /**
     * @param $specs
     * @return self
     */
    public function setSpecs($specs)
    {
        $this->specs = array();

        foreach ($specs as $spec) {
            $this->addSpec($spec);
        }

        return $this;
    }

    /**
     * @return documents
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    public function addDocument($document)
    {
        $document->setParent($this);
        $this->documents[] = $document;
        return $this;
    }

    /**
     * @param $documents
     * @return self
     */
    public function setDocuments($documents)
    {
        $this->documents = array();

        foreach ($documents as $document) {
            $this->addDocument($document);
        }

        return $this;
    }

    /**
     * @return features
     */
    public function getFeatures()
    {
        return $this->features;
    }

    public function addFeature($feature)
    {
        $feature->setParent($this);
        $this->features[] = $feature;
        return $this;
    }

    /**
     * @param $features
     * @return self
     */
    public function setFeatures($features)
    {
        $this->features = array();

        foreach ($features as $feature) {
            $this->addFeature($feature);
        }

        return $this;
    }

    /**
     * @return options
     */
    public function getOptions()
    {
        return $this->options;
    }

    public function addOption($option)
    {
        $option->setParent($this);
        $this->options[] = $option;
        return $this;
    }

    /**
     * @param $options
     * @return self
     */
    public function setOptions($options)
    {
        $this->options = array();

        foreach ($options as $option) {
            $this->addOption($option);
        }

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
    public function setManufacturer(\SpeckContact\Entity\Company $manufacturer = null)
    {
        if ($manufacturer) {
            $manufacturer->setParent($this);
        }
        $this->manufacturer = $manufacturer;
        return $this;
    }

    public function __toString()
    {
        $name = $this->getName();
        $parent = parent::__toString();
        return ($name ?: $parent);
    }

    /**
     * @return parent
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param $parent
     * @return self
     */
    public function setParent(AbstractModel $parent)
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return builders
     */
    public function getBuilders()
    {
        return $this->builders;
    }

    /**
     * @param $builders
     * @return self
     */
    public function setBuilders($builders)
    {
        $this->builders = $builders;
        return $this;
    }
}
