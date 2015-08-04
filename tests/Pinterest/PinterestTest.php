<?php
/**
 * Copyright 2015 Dirk Groenen 
 *
 * (c) Dirk Groenen <dirk@bitlabs.nl>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DirkGroenen\Pinterest\Tests;

use DirkGroenen\Pinterest\Pinterest;

class PinterestTest extends \PHPUnit_Framework_TestCase{
    
    /**
     * Instance of Pinterest class
     * 
     * @var Pinterest
     */
    protected $pinterest;

    /**
     * Setup a new instance of the Pinterest class
     *
     * @return void
     */
    protected function setUp()
    {
        $this->pinterest = new Pinterest( CLIENT_ID, CLIENT_SECRET );
    }

    public function testAuthInstance()
    {
        //$this->assertInstanceOf( 'DirkGroenen\Pinterest\Auth\PinterestOAuth', $this->pinterest->auth );
    }

    public function testLoginUrlCreator()
    {
        //$this->assertTrue( is_string( $this->pinterest->auth->getLoginUrl( CALLBACK_URL ) ) );
        //$this->assertContains( urlencode( CALLBACK_URL ), $this->pinterest->auth->getLoginUrl( CALLBACK_URL ) );
    }

}