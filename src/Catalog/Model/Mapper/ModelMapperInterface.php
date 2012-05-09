<?php
namespace Catalog\Model\Mapper;
interface ModelMapperInterface
{
    /**
     * getModel 
     *
     * returns a new model
     */
    public function getModel($constructor);
    
    /**
     * getAll 
     * 
     * simple, fetches all rows, and returns matching models from the appropriate table.
     */
    public function getAll();

    /**
     * rowToModel
     *
     * takes a row as an array, and returns a matching model. 
     */
    public function rowToModel($row);

    /**
     * deleteById 
     * 
     */
    public function deleteById($id);
    
    /**
     * getById 
     * 
     * returns model of matching id
     */
    public function getById($id);
    
    /**
     * getModelsBySearchData 
     * 
     * returns models where search_data LIKE %string%
     */
    public function getModelsBySearchData($string);
    
    /**
     * persist 
     * 
     * create/update a record.
     */
    public function persist($model, $mode);
}                       
