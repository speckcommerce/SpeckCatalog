<?php
namespace Catalog\Model\Mapper;
use ArrayObject;
abstract class MediaMapperAbstract extends ModelMapperAbstract
{
    protected $primaryKey = 'media_id';
    protected $tableName = 'catalog_media';

    public function __construct($adapter)
    {
        $unsetKeys = array('media_type', 'base_url');
        parent::__construct($adapter, $unsetKeys);
    }

    public function getMediaByProductId($productId)
    {
        $linkerName = $this->getParentProductLinkerTableName();
        $select = $this->select()->from($this->tableName)
            ->join($linkerName, $this->tableName . '.media_id = ' . $linkerName . '.media_id')
            ->where(array('product_id' => $productId));
        //->order('sort_weight DESC');
        return $this->selectMany($select);
    }

    function getParentProductLinkerTableName()
    {
        return $this->parentProductLinkerTableName;
    }
}
