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
     * Constructor
     * 
     * @param  string   $host  posibility to override the host
     */
    public function __construct( $host = null )
    {
        if($host != null)
            $this->host = $host;
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
                "Content-Type: application/x-www-form-urlencoded"
            ));
        }

        // Setup CURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiCall);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_TIMEOUT, 90);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        switch ($method) {
            case 'POST':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');  
                curl_setopt($ch, CURLOPT_POST, count($parameters));
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
                break;
            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
            case 'PATCH':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
                break;
            default:
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                break;
        }

        // Execute request and catch response
        $response_data = curl_exec($ch);

        // Check if we have a valid response
        if ( !$response_data || curl_errno($ch) ) {
            throw new PinterestException('Error: execute() - cURL error: ' . curl_error($ch));
        }

        // Initiate the response
        $response = new Response($response_data, $ch);

        // Check the response code
        if ( $response->getResponseCode() >= 400 ) {
            throw new PinterestException('Pinterest error (code: ' . $response->getResponseCode() . ') with message: ' . $response->message);
        }

        // Close curl resource
        curl_close($ch);
        
        // Return the response
        return $response;
    }

}