<?php
namespace Catalog\Model;
class Spec extends ModelAbstract
{
    protected $specId;
    protected $productId;
    protected $label;
    protected $value;
 
    /**
     * Get label.
     *
     * @return label
     */
    public function getLabel()
    {
        return $this->label;
    }
 
    /**
     * Set label.
     *
     * @param $label the value to be set
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }
 
    /**
     * Get value.
     *
     * @return value
     */
    public function getValue()
    {
        return $this->value;
    }
 
    /**
     * Set value.
     *
     * @param $value the value to be set
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
 
    /**
     * Get specId.
     *
     * @return specId
     */
    public function getSpecId()
    {
        return $this->specId;
    }
 
    /**
     * Set specId.
     *
     * @param $specId the value to be set
     */
    public function setSpecId($specId)
    {
        $this->specId = $specId;
        return $this;
    }

    public function getId()
    {
        return $this->getSpecId();
    }

    public function setId($id)
    {
        return $this->setSpecId($id);
    }

    public function __toString()
    {
        if($this->getLabel()){
            return $this->getLabel();
        }else{
            return '';
        }
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function setProductId($productId)
    {
        $this->productId = $productId;
        return $this;
    }
    public function setParentProductId($productId)
    {
        return $this->setProductId($productId);
    }
}
