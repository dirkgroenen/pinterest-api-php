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

class Pinterest {
    
    /**
     * Reference to authentication class instance
     * 
     * @var Auth\PinterestOAuth
     */
    public $auth;

    /**
     * Constructor
     * 
     * @param  string   $client_id
     * @param  string   $client_secret
     * @param  string   $redirect_uri
     */
    public function __construct($client_id, $client_secret)
    {
        // Create and set new instance of the OAuth class
        $this->auth = new PinterestOAuth($client_id, $client_secret);
    }

}