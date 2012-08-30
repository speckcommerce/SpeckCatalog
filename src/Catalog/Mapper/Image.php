<?php

namespace Catalog\Mapper;

class Image extends AbstractMedia
{
    protected $product  = 'catalog_product_image_linker';
    protected $category = 'catalog_category_image_linker';
    protected $option   = 'catalog_option_image_linker';

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
}
