<?php 
/**
 * Copyright 2015 Dirk Groenen 
 *
 * (c) Dirk Groenen <dirk@bitlabs.nl>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DirkGroenen\Pinterest;

use DirkGroenen\Pinterest\Auth\PinterestOAuth;
use DirkGroenen\Pinterest\Utils\CurlBuilder;
use DirkGroenen\Pinterest\Transport\Request;
use DirkGroenen\Pinterest\Exceptions\InvalidEndpointException;

class Pinterest {
    
    /**
     * Reference to authentication class instance
     * 
     * @var Auth\PinterestOAuth
     */
    public $auth;

    /**
     * A reference to the request class which travels
     * through the application 
     * 
     * @var Transport\Request
     */
    public $request;

    /**
     * A array containing the cached endpoints
     * 
     * @var array
     */
    private $cachedEndpoints = [];

    /**
     * Constructor
     * 
     * @param  string       $client_id
     * @param  string       $client_secret
     * @param  CurlBuilder  $curlbuilder
     * @param  string       $redirect_uri
     */
    public function __construct($client_id, $client_secret, $curlbuilder = null)
    {
        if($curlbuilder == null)
            $curlbuilder = new CurlBuilder();

        // Create new instance of Transport\Request
        $this->request = new Request( $curlbuilder );

        // Create and set new instance of the OAuth class
        $this->auth = new PinterestOAuth($client_id, $client_secret, $this->request);
    }

    /**
     * Get an Instagram API endpoint
     *
     * @access public
     * @param string    $endpoint
     * @return mixed 
     * @throws Exceptions\InvalidEndpointException
     */
    public function __get($endpoint)
    {
        $endpoint = strtolower($endpoint);
        $class = "\\DirkGroenen\\Pinterest\\Endpoints\\" . ucfirst($endpoint);
        
        // Check if an instance has already been initiated
        if(!isset($this->cachedEndpoints[$endpoint])){
            // Check endpoint existence
            if(!class_exists($class))
                throw new InvalidEndpointException;

            // Create a reflection of the called class and initialize it 
            // with a reference to the request class
            $ref = new \ReflectionClass($class);
            $obj = $ref->newInstanceArgs([ $this->request, $this ]);        

            $this->cachedEndpoints[$endpoint] = $obj;
        }

        return $this->cachedEndpoints[$endpoint];
    }
}