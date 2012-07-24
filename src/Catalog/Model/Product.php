<?php

namespace Catalog\Model;

class Product extends LinkedModelAbstract
{
    /**
     * type
     *
     * @var string
     * @access protected
     */
    protected $type; // shell, item, builder

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

    /**
     * manufacturerCompanyId
     *
     * @var int
     * @access protected
     */
    protected $manufacturerCompanyId;

    /**
     * uoms
     *
     * @var array
     * @access protected
     */
    protected $uoms;

    public function setType($type = null)
    {
        if($type !== 'shell' && $type !== 'item' && $type !== 'builder'){
            throw new \InvalidArgumentException("invalid type, must be 'shell', 'item', or 'builder'");
        }

        $this->type = $type;
        return $this;
    }

    public function __construct($type=null)
    {
        if(!$type){
            $type = 'shell';
        }
        $this->setType($type);
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

    public function getType()
    {
        return $this->type;
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

    public function isItem(){
        if($this->getType() === 'item'){
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

    public function getManufacturerCompanyId()
    {
        return $this->manufacturerCompanyId;
    }

    public function setManufacturerCompanyId($companyId)
    {
        $this->manufacturerCompanyId = (int) $companyId;
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

    public function getPrice($uomCode = null)
    {
        if($uomCode){
            if($this->hasUoms()){
                foreach($this->getUoms as $uom){
                    if($uomCode === $uom->getUomCode){
                        return $uom->getPrice();
                    }
                }
            }
        }
        if(isset($this->uomForPrice)){
            return $this->uomForPrice->getPrice();
        }
        //temporary
        if($this->has('uoms')){
            $uoms = $this->getUoms();
            return $uoms[0]->getPrice();
        }
    }
}
