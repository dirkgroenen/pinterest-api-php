<?php 
/**
 * Copyright 2015 Dirk Groenen 
 *
 * (c) Dirk Groenen <dirk@bitlabs.nl>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DirkGroenen\Pinterest\Utils;

use DirkGroenen\Pinterest\Exceptions\PinterestException;

class CurlBuilder {
    
    /**
     * Contains the curl instance
     *
     * @var resource
     */
    private $curl;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->curl = curl_init();
    }

    /**
     * Return a new instance of the CurlBuilder
     * 
     * @access public
     * @return CurlBuilder
     */
    public function create()
    {
        return new self();
    }

    /**
     * Sets an option in the curl instance
     * 
     * @access public
     * @param  string   $option
     * @param  string   $value
     * @return $this
     */
    public function setOption( $option, $value )
    {
        curl_setopt($this->curl, $option, $value );

        return $this;
    }

    /**
     * Sets multiple options at the same time
     * 
     * @access public
     * @param  array   $options
     * @return $this
     */
    public function setOptions( array $options = [] )
    {
        curl_setopt_array($this->curl, $options);

        return $this;
    }

    /**
     * Execute the curl request
     * 
     * @access public
     * @return mixed
     */
    public function execute()
    {
        return curl_exec($this->curl);
    }

    /**
     * Check if the curl request ended up with errors
     * 
     * @access public
     * @return boolean
     */
    public function hasErrors()
    {
        return curl_errno($this->curl);
    }

    /**
     * Get curl errors
     * 
     * @access public
     * @return string
     */
    public function getErrors()
    {
        return curl_error($this->curl);
    }

    /**
     * Get curl info key
     * 
     * @access public
     * @param  string  $key
     * @return string
     */
    public function getInfo($key)
    {
        return curl_getinfo($this->curl, $key);
    }

    /**
     * Close the curl resource 
     * 
     * @access public
     * @return void
     */
    public function close()
    {
        curl_close($this->curl);
    }
}