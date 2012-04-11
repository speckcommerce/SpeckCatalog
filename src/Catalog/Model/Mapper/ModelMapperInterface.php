<?php
namespace Catalog\Model\Mapper;
interface ModelMapperInterface
{
    /**
     * getModel 
     *
     * returns a new model
     */
    public function getModel();
    
    /**
     * newModel 
     *
     * name is misleading, this method reuturns a model that has been 
     * instantiated, and written to the the catalog 
     * todo: rename this and references to it, to something more explanatory
     */
    public function newModel();
    
    /**
     * getAll 
     * 
     * simple, fetches all rows, and returns matching models from the appropriate table.
     */
    public function getAll();

    /**
     * mapModel
     *
     * takes a row as an array, and returns a matching model. 
     */
    public function mapModel($row);


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
    
    public function getIdField(); 
}                       
