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

class Model {

    /**
     * The model's attributes
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Create a new model instance
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = array())
    {
        $this->fill($attributes);
    }

    /**
     * Get the model's attribute
     * 
     * @access public
     * @param  string   $attribute
     * @return void
     */
    public function __get($attribute)
    {
        $this->getAttribute($attribute);
    }

    /**
     * Set the model's attribute
     * 
     * @access public
     * @param  string   $attribute
     * @return void
     */
    public function __set($attribute)
    {
        $this->setAttribute($attribute);    
    }

    /**
     * Fill the attributes
     *
     * @access private
     * @param  array   $attributes
     * @return void
     */
    private function fill(array $attributes)
    {

    }
}