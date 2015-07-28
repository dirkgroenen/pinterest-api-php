<?php 
/**
 * Copyright 2015 Dirk Groenen 
 *
 * (c) Dirk Groenen <dirk@bitlabs.nl>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DirkGroenen\Pinterest\Auth;

use DirkGroenen\Pinterest\Transport\Request;
use DirkGroenen\Pinterest\Exceptions\PinterestException;

class PinterestOAuth {
    
    /**
     * The application ID
     * 
     * @var string
     */
    private $client_id;

    /**
     * The app secret
     * 
     * @var string
     */
    private $client_secret;

    /**
     * Random string indicating the state 
     * to prevent spoofing
     * 
     * @var void
     */
    private $state;

    /**
     * Pinterest's oauth endpoint
     */
    const AUTH_HOST = "https://api.pinterest.com/oauth/";

    /**
     * Construct
     * 
     * @param  string   $client_id
     * @param  string   $client_secret
     */
    public function __construct($client_id, $client_secret)
    {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;

        // Generate and set the state
        $this->state = $this->generateState();
    }

    /**
     * Returns the login url
     * 
     * @access public
     * @param  array    $scopes
     * @param  string   $redirect_uri
     * @return string
     */
    public function getLoginUrl($redirect_uri, $scopes = array("read_public"))
    {
        $queryparams = array(
            "response_type"     => "token",
            "redirect_uri"      => $redirect_uri,
            "client_id"         => $this->client_id,
            "client_secret"     => $this->client_secret,
            "scope"             => implode(",", $scopes),
            "state"             => $this->state
        );

        // Build url and return it
        return sprintf( "%s?%s", self::AUTH_HOST, http_build_query($queryparams) );
    }

    /**
     * Generates a random string and returns is
     * 
     * @access private
     * @return string       random string
     */
    private function generateState()
    {
        return substr( md5( rand() ), 0, 7 );
    }

    /**
     * 
     * 
     * @param  [type]   $code [description]
     * @return [type]         [description]
     */
    public function getOAuthToken($code)
    {
        // Initialize new request 
        $request = new Request();

        // Build data array
        $data = array(
            "grant_type"    => "authorization_code",
            "client_id"     => $this->client_id,
            "code"          => $code
        );

        // Perform post request
        $response = $request->post("oauth/token", $data);

        var_dump($response);
    }

}