<?php

namespace Catalog\Model;

class Product extends LinkedModelAbstract
{
    protected $productId;

    protected $typeId = 2;         // 1, 2

    /**
     * name
     *
     * @var string
     * @access protected
     */
    protected $name;

    /**
     * description
     *
     * @var string
     * @access protected
     */
    protected $description;

    /**
     * options
     *
     * @var array
     * @access protected
     */
    protected $options;

    /**
     * parentChoices
     *
     * @var array
     * @access protected
     */
    protected $parentChoices;

    /**
     * specs
     *
     * @var array
     * @access protected
     */
    protected $specs;

    /**
     * documents
     *
     * @var array
     * @access protected
     */
    protected $documents;

    /**
     * images
     *
     * @var array
     * @access protected
     */
    protected $images;

    /**
     * itemNumber
     *
     * @var string
     * @access protected
     */
    protected $itemNumber;

    /**
     * manufacturer
     *
     * @var object Catalog\Model\Company
     * @access protected
     */
    protected $manufacturer;

    protected $manufacturerId;

    /**
     * uoms
     *
     * @var array
     * @access protected
     */
    protected $uoms;

    public function setTypeId($typeId)
    {
        if ($typeId > 2) {
            throw new \Exception('invalid type id');
        }
        $this->typeId = $typeId;
        return $this;
    }

    public function addOption(Option $option)
    {
        $this->options[] = $option;
        return $this;
    }

    public function setOptions($options)
    {
        if(is_array($options) && count($options) > 0){
            $this->options = array();
            foreach($options as $option){
                $this->addOption($option);
            }
        }
        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setDescription($description)
    {
        $this->description = htmlentities($description, ENT_QUOTES, "UTF-8", false);
        return $this;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getParentChoices()
    {
        return $this->parentChoices;
    }

    public function setParentChoices($parentChoices)
    {
        $this->parentChoices = $parentChoices;
        return $this;
    }

    public function isProduct()
    {
        if($this->getTypeId() === '1'){
            return true;
        }
    }

    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    public function setManufacturer($manufacturer)
    {
        $this->manufacturer = $manufacturer;
        return $this;
    }

    public function getItemNumber()
    {
        return $this->itemNumber;
    }

    public function setItemNumber($itemNumber)
    {
        $this->itemNumber = $itemNumber;
        return $this;
    }

    public function getUoms()
    {
        return $this->uoms;
    }

    public function setUoms($uoms)
    {
        $this->uoms = $uoms;
        return $this;
    }
    public function __toString()
    {
        return '' . $this->getName();
    }

    public function getSpecs()
    {
        return $this->specs;
    }

    public function setSpecs($specs)
    {
        $this->specs = $specs;
        return $this;
    }
    public function getDocuments()
    {
        return $this->documents;
    }

    public function setDocuments($documents)
    {
        $this->documents = $documents;
        return $this;
    }
    public function getFirstImage()
    {
        if($this->has('images')){
            $images = $this->getImages();
            return $images[0];
        }
    }

    public function getImages()
    {
        return $this->images;
    }

    public function setImages($images)
    {
        $this->images = $images;
        return $this;
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

    function getProductId()
    {
        return $this->productId;
    }

    function setProductId($productId)
    {
        $this->productId = $productId;
        return $this;
    }

    public function getId()
    {
        return $this->productId;
    }

    public function setId($id)
    {
        return $this->setProductId($id);
    }

    /**
     * @return typeId
     */
    public function getTypeId()
    {
        return $this->typeId;
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
        $this->manufacturerId = $manufacturerId;
        return $this;
    }
}
