<?php
namespace Catalog\Model\Mapper;
use Catalog\Model\Image,
    ArrayObject;
class ImageMapper extends MediaMapperAbstract
{
    protected $parentOptionLinkerTableName = 'catalog_option_image_linker';
    protected $parentProductLinkerTableName = 'catalog_product_image_linker';

    public function getModel($constructor=null)
    {
        return new Image;
    }

    public function getImagesByOptionId($optionId)
    {
        $linkerName = $this->getParentOptionLinkerTable()->getTable();
        $select = $this->newSelect();
        $select->from($this->getTableName())
            ->join($linkerName, $this->getTableName() . '.record_id = ' . $linkerName . '.media_id')
            ->where(array('option_id' => $optionId));
        //->order('sort_weight DESC');
        return $this->selectMany($select);
    }

    public function linkParentProduct($productId, $imageId)
    {
        $table = $this->getParentProductLinkerTable();
        $row = array(
            'product_id' => $productId,
            'media_id' => $imageId,
        );
        return $this->insertLinker($table, $row);
    }
    public function linkParentOption($optionId, $imageId)
    {
        $table = $this->getParentOptionLinkerTable();
        $row = array(
            'option_id' => $optionId,
            'media_id' => $imageId,
        );
        return $this->insertLinker($table, $row);
    }

    public function updateProductImageSortOrder($order)
    {
        return $this->updateSort('catalog_product_image_linker', $order);
    }

    public function removeLinker($linkerId)
    {
        return $this->deleteLinker('catalog_product_image_linker', $linkerId);
    }

    public function getParentOptionLinkerTable()
    {
        if(null === $this->parentOptionLinkerTable){
            $this->parentOptionLinkerTable = $this->getServiceManager()->get('catalog_option_image_linker_tg');
        }
        return $this->parentOptionLinkerTable;
    }

    public function setParentOptionLinkerTable($parentOptionLinkerTable)
    {
        $this->parentOptionLinkerTable = $parentOptionLinkerTable;
        return $this;
    }
    public function getParentProductLinkerTable()
    {
        return $this->getServiceManager()->get('catalog_product_image_linker_tg');
    }
}

