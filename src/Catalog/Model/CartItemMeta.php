<?php

namespace Catalog\Model;

class CartItemMeta
{
    protected $parentOptionId;
    protected $parentOptionName;
    protected $image;

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
}
