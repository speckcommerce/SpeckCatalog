<?php

namespace Catalog\Mapper;

class Image extends AbstractMapper
{
    protected $tableName;
    protected $entityPrototype = 'Catalog\Entity\Image';
    protected $hydrator        = 'Catalog\Hydrator\Image';

    public function setParentType($parentType)
    {
        $this->tableName = 'catalog_' . $parentType . '_image';
        return $this;
    }

    public function find($mediaId)
    {
        $table = $this->getTableName();
        $where = array('media_id' => $mediaId);
        $select = $this->getSelect()
            ->from($table)
            ->where($where);
        return $this->selectOne($select);
    }

    public function getImages($type, $id)
    {
        $where = array($type . '_id' => $id);

        $select = $this->getSelect()
            ->from($this->getTableName())
            ->where($where);
        return $this->selectMany($select);
    }

    public function persist($image)
    {
        if(null === $image->getImageId()){
            $id = $this->insert($image);
            return $image->setImageId($id);
        } elseif($this->find($image->getMediaId())) {
            $where = array('image_id' => $image->getImageId());
            return $this->update($image, $where);
        }
    }

    public function addLinker($parentName, $parentId, $imageId)
    {
        die();
        $table = $this->$parentName;
        $row = array(
            $parentName . '_id' => $parentId,
            'media_id' => $imageId,
        );
        $select = $this->getSelect()
            ->from($table)
            ->where($row);
        $result = $this->query($select);
        if (false === $result) {
            $this->insert($row, $this->$parentName);
        }
    }
}
