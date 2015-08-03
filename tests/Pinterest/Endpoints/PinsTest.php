<?php
/**
 * Copyright 2015 Dirk Groenen 
 *
 * (c) Dirk Groenen <dirk@bitlabs.nl>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DirkGroenen\Pinterest\Tests\Endpoints;

use DirkGroenen\Pinterest\Pinterest;

class PinsTest extends \PHPUnit_Framework_TestCase{
    
    /**
     * Instance of Pinterest class
     * 
     * @var Pinterest
     */
    protected $pinterest;

    /**
     * ID of the created pin
     * 
     * @var string
     */
    private $pin_id;

    /**
     * Setup a new instance of the Pinterest class
     *
     * @return void
     */
    protected function setUp()
    {
        $this->pinterest = new Pinterest(CLIENT_ID, CLIENT_SECRET);
        $this->pinterest->auth->setOAuthToken( ACCESS_TOKEN );
    }

    public function testPinsEndpointExistence()
    {
        $this->assertInstanceOf( 'DirkGroenen\Pinterest\Endpoints\Pins', $this->pinterest->pins );
    }

    public function testCreate()
    {
        $pin = $this->pinterest->pins->create(array(
           "board"      => "503066289565420161",
           "note"       => "Test from Pinterest PHP API Wrapper",
           "link"       => "https://github.com/dirkgroenen/Pinterest-API-PHP",
           "image_url"  => "https://upload.wikimedia.org/wikipedia/commons/c/c1/PHP_Logo.png"
        ));

        // Save pin ID for later
        $this->pin_id = $pin->id;

        // Do assertions
        $this->assertInstanceOf( 'DirkGroenen\Pinterest\Models\Pin', $pin );
        $this->assertEquals( $pin->note , "Test from Pinterest PHP API Wrapper" );

        return $this->pin_id;
    }

    public function testFromBoard()
    {
        $pins = $this->pinterest->pins->fromBoard("503066289565420161");

        $this->assertInstanceOf( 'DirkGroenen\Pinterest\Models\Collection', $pins );
        $this->assertInstanceOf( 'DirkGroenen\Pinterest\Models\Pin', $pins->get(0) );    
    }

    /**
     * @depends testCreate
     */
    public function testUpdate($pin_id)
    {
        // Despite Pinterest's documentation it looks like PATCH hasn't been integrated in their API yet. 
        // 
        /*
        $this->pin_id = $pin_id;

        $pin = $this->pinterest->pins->update($this->pin_id, array(
           "note"       => "Test from Pinterest PHP API Wrapper, note should have been updated"
        ));

        // Do assertions
        $this->assertInstanceOf( 'DirkGroenen\Pinterest\Models\Pin', $pin );
        $this->assertEquals( $pin->note , "Test from Pinterest PHP API Wrapper, note should have been updated" );
        */
    }

    /**
     * @depends testCreate
     */
    public function testDelete($pin_id)
    {
        $this->pin_id = $pin_id;

        $pin = $this->pinterest->pins->delete($this->pin_id);

        $this->assertInstanceOf( 'DirkGroenen\Pinterest\Models\Pin', $pin );
    }


}