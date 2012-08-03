<?php
namespace Catalog\Model\Mapper;
use Catalog\Model\Image,
    ArrayObject;
class ImageMapper extends MediaMapperAbstract
{
    protected $parentOptionLinkerTableName = 'catalog_option_image_linker';
    protected $parentProductLinkerTableName = 'catalog_product_image_linker';
    protected $parentCategoryLinkerTableName = 'catalog_category_image_linker';

    public function getModel($constructor=null)
    {
        return new Image;
    }

    public function getImagesByOptionId($optionId)
    {
        $linkerName = $this->parentOptionLinkerTableName;
        $select = $this->select()->from($this->getTableName())
            ->join($linkerName, $this->getTableName() . '.media_id = ' . $linkerName . '.media_id')
            ->where(array('option_id' => $optionId));
        //->order('sort_weight DESC');
        return $this->selectMany($select);
    }

    public function getImageForCategory($categoryId)
    {
        $linkerName = $this->parentCategoryLinkerTableName;
        $select = $this->select()->from($this->getTableName())
            ->join($linkerName, $this->getTableName() . '.media_id = ' . $linkerName . '.media_id')
            ->where(array('category_id' => $categoryId));
        //->order('sort_weight DESC');
        return $this->selectWith($select);
    }

    public function linkParentProduct($productId, $imageId)
    {
        $row = array(
            'product_id' => $productId,
            'media_id' => $imageId,
        );
        return $this->add($row, $this->parentProductLinkerTableName);
    }

    public function linkParentOption($optionId, $imageId)
    {
        $row = array(
            'option_id' => $optionId,
            'media_id' => $imageId,
        );
        return $this->add($row, $this->parentOptionLinkerTableName);
    }

    public function linkParentCategory($categoryId, $imageId)
    {
        $row = array(
            'category_id' => $categoryId,
            'media_id' => $imageId,
        );
        return $this->add($row, $this->parentCategoryLinkerTableName);
    }

    public function updateProductImageSortOrder($order)
    {
        return $this->updateSort('catalog_product_image_linker', $order);
    }

    public function removeLinker($linkerId)
    {
        return $this->deleteLinker('catalog_product_image_linker', $linkerId);
    }
}

