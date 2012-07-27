<?php
namespace Catalog\Model;
class Spec extends ModelAbstract
{
    protected $specId;
    protected $productId;
    protected $label;
    protected $value;
    protected $tabDelimited;

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

    /**
     * Get tabDelimited.
     *
     * @return tabDelimited
     */
    public function getTabDelimited()
    {
        return $this->tabDelimited;
    }

    /**
     * Set tabDelimited.
     *
     * @param $tabDelimited the value to be set
     */
    public function setTabDelimited($tabDelimited)
    {
        $this->tabDelimited = $tabDelimited;
        return $this;
    }

 /**
  * Get specId.
  *
  * @return specId.
  */
 function getSpecId()
 {
     return $this->specId;
 }

 /**
  * Set specId.
  *
  * @param specId the value to set.
  */
 function setSpecId($specId)
 {
     $this->specId = $specId;
 }
    public function getId()
    {
        return $this->specId;
    }
    public function setId($id)
    {
        return $this->setSpecId($id);
    }
}
