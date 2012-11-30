<?php

namespace SpeckCatalog\Mapper;

class Image extends AbstractMapper
{
    protected $tableName;
    protected $relationalModel;
    protected $dbModel;

    protected $dbModels = array(
        'product' => 'SpeckCatalog\Model\ProductImage',
        'option'  => 'SpeckCatalog\Model\OptionImage',
    );

    protected $relationalModels = array(
        'product' => 'SpeckCatalog\Model\ProductImage\Relational',
        'option'  => 'SpeckCatalog\Model\OptionImage\Relational',
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
        $where = array('image_id' => $data['image_id']);
        $select = $this->getSelect()
            ->where($where);
        return $this->selectOne($select);
    }

    public function getImages($type, $id)
    {
        $this->setParentType($type);

        $where = array($type . '_id' => $id);

        $select = $this->getSelect()
            ->where($where);
        return $this->selectMany($select);
    }
}
