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

    public function __construct(array $config = array())
    {
        if (count($config)) {
            $this->parentOptionId   = isset($config['parent_option_id'])   ? $config['parent_option_id']   : null;
            $this->productId        = isset($config['product_id'])         ? $config['product_id']         : null;
            $this->itemNumber       = isset($config['item_number'])        ? $config['item_number']        : null;
            $this->parentOptionName = isset($config['parent_option_name']) ? $config['parent_option_name'] : null;
            $this->flatOptions      = isset($config['flat_options'])       ? $config['flat_options']       : array();
            $this->image            = isset($config['image'])              ? $config['image']              : null;
            $this->uom              = isset($config['uom'])                ? $config['uom']                : null;
        }
    }

    /**
     * Get parentOptionId.
     *
     * @return parentOptionId.
     */
    public function getParentOptionId()
    {
        return $this->parentOptionId;
    }

    /**
     * Set parentOptionId.
     *
     * @param parentOptionId the value to set.
     */
    public function setParentOptionId($parentOptionId)
    {
        $this->parentOptionId = $parentOptionId;
        return $this;
    }

    /**
     * Get parentOptionName.
     *
     * @return parentOptionName.
     */
    public function getParentOptionName()
    {
        return $this->parentOptionName;
    }

    /**
     * Set parentOptionName.
     *
     * @param parentOptionName the value to set.
     */
    public function setParentOptionName($parentOptionName)
    {
        $this->parentOptionName = $parentOptionName;
        return $this;
    }

    /**
     * Get image.
     *
     * @return image.
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set image.
     *
     * @param image the value to set.
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * Get productId.
     *
     * @return productId.
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * Set productId.
     *
     * @param productId the value to set.
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
        return $this;
    }

    /**
     * Get flatOptions.
     *
     * @return flatOptions.
     */
    public function getFlatOptions()
    {
        return $this->flatOptions;
    }

    /**
     * Set flatOptions.
     *
     * @param flatOptions the value to set.
     */
    public function setFlatOptions($flatOptions)
    {
        $this->flatOptions = $flatOptions;
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
