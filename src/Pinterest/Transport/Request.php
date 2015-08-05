<?php 
/**
 * Copyright 2015 Dirk Groenen 
 *
 * (c) Dirk Groenen <dirk@bitlabs.nl>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DirkGroenen\Pinterest\Transport;

use DirkGroenen\Pinterest\Utils\CurlBuilder;
use DirkGroenen\Pinterest\Exceptions\PinterestException;

class Request {
    
    /**
     * Host to make the calls to
     *
     * @var string
     */
    private $host = "https://api.pinterest.com/v1/";

    /**
     * Access token
     * 
     * @var string
     */
    protected $access_token = null;

    /**
     * Instance of the CurlBuilder class
     * 
     * @var CurlBuilder
     */
    private $curlbuilder;

    /**
     * Constructor
     * 
     * @param  CurlBuilder   $curlbuilder
     */
    public function __construct( CurlBuilder $curlbuilder )
    {
        $this->curlbuilder = $curlbuilder;
    }

    /**
     * Set the access token
     * 
     * @access public
     * @param  string   $token
     */
    public function setAccessToken( $token )
    {
        $this->access_token = $token;
    }

    /**
     * Make a get request to the given endpoint
     * 
     * @access public
     * @param  string   $endpoint  
     * @param  array    $parameters
     * @return [type]
     */
    public function get( $endpoint, array $parameters = array() )
    {
        if(!empty($parameters)) {
            $path = sprintf("%s/?%s", $endpoint, http_build_query($parameters));
        }
        else {
            $path = $endpoint;
        }

        return $this->execute("GET", sprintf("%s%s", $this->host, $path));
    }

    /**
     * Make a post request to the given endpoint
     * 
     * @access public
     * @param  string   $endpoint  
     * @param  array    $parameters
     * @return [type]
     */
    public function post( $path, array $parameters = array() )
    {
        return $this->execute("POST", sprintf("%s%s", $this->host, $path) . "/", $parameters );
    }

    /**
     * Make a delete request to the given endpoint
     * 
     * @access public
     * @param  string   $endpoint  
     * @param  array    $parameters
     * @return [type]
     */
    public function delete( $path, array $parameters = array() )
    {
        return $this->execute("DELETE", sprintf("%s%s", $this->host, $path) . "/", $parameters );
    }

    /**
     * Make an update request to the given endpoint
     * 
     * @access public
     * @param  string   $endpoint  
     * @param  array    $parameters
     * @return [type]
     */
    public function update( $path, array $parameters = array() )
    {
        return $this->execute("PATCH", sprintf("%s%s", $this->host, $path) . "/", $parameters );
    }

    /**
     * Execute the http request
     * 
     * @access public
     * @param  string   $method     
     * @param  string   $apiCall       
     * @param  array    $parameters 
     * @param  array    $headers 
     * @return mixed
     */
    public function execute( $method, $apiCall, array $parameters = array(), $headers = array() )
    {   
        // Check if the access token needs to be added 
        if($this->access_token != null){
            $headers = array_merge($headers, array(
                "Authorization: Bearer " . $this->access_token,
                "Content-ype: multipart/form-data",
            ));
        }

        // Setup CURL
        $ch = $this->curlbuilder->create();

        // Set default options
        $ch->setOptions( array(
            CURLOPT_URL             => $apiCall,
            CURLOPT_HTTPHEADER      => $headers,
            CURLOPT_CONNECTTIMEOUT  => 20,
            CURLOPT_TIMEOUT         => 90,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_SSL_VERIFYPEER  => false,
            CURLOPT_SSL_VERIFYHOST  => false,
            CURLOPT_HEADER          => false,
            CURLINFO_HEADER_OUT     => true,
            CURLOPT_FOLLOWLOCATION  => true
        ) );

        switch ($method) {
            case 'POST':
                $ch->setOptions( array(
                    CURLOPT_CUSTOMREQUEST   => 'POST',
                    CURLOPT_POST            => count($parameters),
                    CURLOPT_POSTFIELDS      => $parameters
                ) );

                if(defined('CURLOPT_SAFE_UPLOAD'))
                    $ch->setOption( CURLOPT_SAFE_UPLOAD, false );

                break;
            case 'DELETE':
                $ch->setOption( CURLOPT_CUSTOMREQUEST, "DELETE" );
                break;
            case 'PATCH':
                $ch->setOption( CURLOPT_CUSTOMREQUEST, "PATCH" );
                break;
            default:
                $ch->setOption( CURLOPT_CUSTOMREQUEST, "GET" );
                break;
        }

        
        // Execute request and catch response
        $response_data = $ch->execute();

        // Check if we have a valid response
        if ( !$response_data || $ch->hasErrors() ) {
            throw new PinterestException( 'Error: execute() - cURL error: ' . $ch->getErrors() );
        }

        // Initiate the response
        $response = new Response($response_data, $ch);

        // Check the response code
        if ( $response->getResponseCode() >= 400 ) {
            throw new PinterestException( 'Pinterest error (code: ' . $response->getResponseCode() . ') with message: ' . $response->message );
        }

        // Close curl resource
        $ch->close();
        
        // Return the response
        return $response;
    }

}