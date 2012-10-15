<?php

namespace Catalog\Mapper;

class Image extends AbstractMapper
{
    protected $tableName;
    protected $relationalModel;
    protected $dbModel;

    protected $dbModels = array(
        'product' => 'Catalog\Model\ProductImage',
        'option'  => 'Catalog\Model\OptionImage',
    );

    protected $relationalModels = array(
        'product' => 'Catalog\Model\ProductImage\Relational',
        'option'  => 'Catalog\Model\OptionImage\Relational',
    );

    public function setParentType($parentType)
    {
        $this->tableName = 'catalog_' . $parentType . '_image';
        $this->dbModel = $this->dbModels[$parentType];
        $this->relationalModel = $this->relationalModels[$parentType];

        return $this;
    }

    public function find(array $data)
    {
        $table = $this->getTableName();
        $where = array('image_id' => $data['image_id']);
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
        $image = $this->getDbModel($image);
        if(null === $image->getImageId()){
            $id = $this->insert($image);
            return $image->setImageId($id);
        } elseif($this->find($image->getMediaId())) {
            $where = array('image_id' => $image->getImageId());
            return $this->update($image, $where);
        }
    }
}
