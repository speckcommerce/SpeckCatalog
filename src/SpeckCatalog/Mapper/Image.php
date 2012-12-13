<?php

namespace SpeckCatalog\Mapper;

class Image extends AbstractMapper
{
    protected $tableName;
    protected $relationalModel;
    protected $dbModel;
    protected $parentType;

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
        $this->parentType = $parentType;
        $this->tableName = 'catalog_' . $parentType . '_image';
        $this->dbModel = $this->dbModels[$parentType];
        $this->relationalModel = $this->relationalModels[$parentType];

        return $this;
    }

    public function find(array $data)
    {
        $where = array('image_id' => $data['image_id']);
        return parent::find($where);
    }

    public function getImages($type, $id)
    {
        $this->setParentType($type);
        $where = array($type . '_id' => $id);
        $select = $this->getSelect()
            ->where($where);
        return $this->selectMany($select);
    }

    /**
     * @return parentType
     */
    public function getParentType()
    {
        return $this->parentType;
    }
}
