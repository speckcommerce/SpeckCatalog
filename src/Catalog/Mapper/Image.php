<?php

namespace Catalog\Mapper;

class Image extends AbstractMedia
{
    protected $product  = 'catalog_product_image_linker';
    protected $category = 'catalog_category_image_linker';
    protected $option   = 'catalog_option_image_linker';

    public function find($mediaId)
    {
        $table = $this->getTableName();
        $where = array('media_id' => $mediaId);
        $select = $this->select()
            ->from($table)
            ->where($where);
        return $this->selectOne($select);
    }

    public function getImages($type, $id)
    {
        $table = $this->getTableName();
        $linker = $this->$type;
        $joinString = $linker . '.media_id = ' . $table . '.media_id';
        $where = array($type . '_id' => $id);

        $select = $this->select()
            ->from($table)
            ->join($linker, $joinString)
            ->where($where);
        return $this->selectMany($select);
    }

    public function persist($image)
    {
        if(null === $image->getMediaId()){
            $id = $this->insert($image);
            return $image->setMediaId($id);
        } elseif($this->find($image->getMediaId())) {
            $where = array('media_id' => $image->getMediaId());
            return $this->update($image, $where);
        } else {
            $id = $this->insert($image);
            return $image->setMediaId($id);
        }
    }

    public function addLinker($parentName, $parentId, $imageId)
    {
        $table = $this->$parentName;
        $row = array(
            $parentName . '_id' => $parentId,
            'media_id' => $imageId,
        );
        $select = $this->select()
            ->from($table)
            ->where($row);
        $result = $this->query($select);
        if (false === $result) {
            $this->insert($row, $this->$parentName);
        }
    }
}
