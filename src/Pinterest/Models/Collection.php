<?php 
/**
 * Copyright 2015 Dirk Groenen 
 *
 * (c) Dirk Groenen <dirk@bitlabs.nl>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DirkGroenen\Pinterest\Models;

class Collection {

    /**
     * The items in the collection
     * 
     * @var array
     */
    protected $items = [];

    /**
     * The model of each collection item
     * 
     * @var Model
     */
    protected $model;

    /**
     * Construct
     * 
     * @access public
     * @param  array    $items
     * @param  string   $model
     * @throws InvalidModelException
     */
    public function __construct(array $items = [], $model){
        $this->model = "\\DirkGroenen\\Pinterest\\Models\\" . ucfirst( strtolower($model) );

        if(!class_exists($this->model))
            throw new InvalidModelException;

        // Transform the raw collection data to models
        $this->items = $this->buildCollectionModels($items);
    }

    /**
     * Get all items from the collection
     * 
     * @access public
     * @return array
     */
    public function all(){
        return $this->items;
    }

    /**
     * Transform each raw item into a model
     * 
     * @access private
     * @param array $items
     * @return array
     */
    private function buildCollectionModels(array $items)
    {
        $modelcollection = [];

        foreach($items as $item){
            $class = new \ReflectionClass($this->model);
            $modelcollection[] = $class->newInstanceArgs( [$item] );
        }

        return $modelcollection;
    }

    /**
     * Convert the collection to an array
     *
     * @return array
     */
    public function toArray()
    {
        $array = [];
        
        foreach($this->items as $item){
            $array[] = $item->toArray();
        }        

        return $array;
    }

    /**
     * Convert the collection to JSON
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * Convert the collection to its string representation
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }
}