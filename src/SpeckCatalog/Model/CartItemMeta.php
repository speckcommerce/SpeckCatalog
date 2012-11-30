<?php

namespace SpeckCatalog\Model;

class CartItemMeta
{
    protected $parentOptionId;
    protected $productId;
    protected $itemNumber;
    protected $parentOptionName;
    protected $flatOptions = array();
    protected $image;
    protected $uom;

 /**
  * Get parentOptionId.
  *
  * @return parentOptionId.
  */
 function getParentOptionId()
 {
     return $this->parentOptionId;
 }

 /**
  * Set parentOptionId.
  *
  * @param parentOptionId the value to set.
  */
 function setParentOptionId($parentOptionId)
 {
     $this->parentOptionId = $parentOptionId;
 }

 /**
  * Get parentOptionName.
  *
  * @return parentOptionName.
  */
 function getParentOptionName()
 {
     return $this->parentOptionName;
 }

 /**
  * Set parentOptionName.
  *
  * @param parentOptionName the value to set.
  */
 function setParentOptionName($parentOptionName)
 {
     $this->parentOptionName = $parentOptionName;
 }

 /**
  * Get image.
  *
  * @return image.
  */
 function getImage()
 {
     return $this->image;
 }

 /**
  * Set image.
  *
  * @param image the value to set.
  */
 function setImage($image)
 {
     $this->image = $image;
 }

 /**
  * Get productId.
  *
  * @return productId.
  */
 function getProductId()
 {
     return $this->productId;
 }

 /**
  * Set productId.
  *
  * @param productId the value to set.
  */
 function setProductId($productId)
 {
     $this->productId = $productId;
 }

 /**
  * Get flatOptions.
  *
  * @return flatOptions.
  */
 function getFlatOptions()
 {
     return $this->flatOptions;
 }

 /**
  * Set flatOptions.
  *
  * @param flatOptions the value to set.
  */
 function setFlatOptions($flatOptions)
 {
     $this->flatOptions = $flatOptions;
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
     * @return uom
     */
    public function getUom()
    {
        return $this->uom;
    }

    /**
     * @param $uom
     * @return self
     */
    public function setUom($uom)
    {
        $this->uom = $uom;
        return $this;
    }
}
