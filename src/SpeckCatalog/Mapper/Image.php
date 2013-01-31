<?php

namespace SpeckCatalog\Mapper;

class Image extends AbstractMapper
{
    protected $tableName;
    protected $model;
    protected $parentType;

    protected $fields = array(
        'product' => array('image_id', 'product_id', 'sort_weight', 'file_name', 'label'),
        'option'  => array(),
    );

    protected $keyFields = array(
        'product' => array('image_id'),
        'option' => array('image_id'),
    );

    protected $models = array(
        'product' => 'SpeckCatalog\Model\ProductImage\Relational',
        'option'  => 'SpeckCatalog\Model\OptionImage\Relational',
    );

    public function setParentType($parentType)
    {
        $this->parentType = $parentType;
        $this->tableName = 'catalog_' . $parentType . '_image';
        $this->model = $this->models[$parentType];

        return $this;
    }

    public function getImages($type, $id)
    {
        $this->setParentType($type);
        $where = array($type . '_id' => $id);
        $select = $this->getSelect()
            ->where($where);
        return $this->selectManyModels($select);
    }

    /**
     * @return parentType
     */
    public function getParentType()
    {
        return $this->parentType;
    }

    public function getTableFields()
    {
        $type = $this->getParentType();
        return $this->fields[$type];
    }
    public function getTableKeyFields()
    {
        $type = $this->getParentType();
        return $this->keyFields[$type];
    }

}
