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

class BoardsTest extends \PHPUnit_Framework_TestCase{
    
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
        $this->pinterest = new Pinterest(CLIENT_ID, CLIENT_SECRET);
        $this->pinterest->auth->setOAuthToken( ACCESS_TOKEN );
    }

    public function testBoardsEndpointExistence()
    {
        $this->assertInstanceOf( 'DirkGroenen\Pinterest\Endpoints\Boards', $this->pinterest->boards );
    }

    public function testCreate()
    {
        $board = $this->pinterest->boards->create(array(
           "name"           => "Pinterest PHP API Test Board",
           "description"    => "Test from Pinterest PHP API Wrapper"
        ));

        // Do assertions
        $this->assertInstanceOf( 'DirkGroenen\Pinterest\Models\Board', $board );
        $this->assertEquals( $board->name, "Pinterest PHP API Test Board" );

        return $board->id;
    }

    /**
     * @depends testCreate
     */
    public function testGet($board_id)
    {
        $board = $this->pinterest->boards->get($board_id);

        $this->assertInstanceOf( 'DirkGroenen\Pinterest\Models\Board', $board );
    }

    /**
     * @depends testCreate
     */
    public function testGetWithExtraData($board_id)
    {
        $board = $this->pinterest->boards->get($board_id, array(
            "fields"    => "counts"
        ));

        $this->assertInstanceOf( 'DirkGroenen\Pinterest\Models\Board', $board );
        $this->assertTrue( is_array( $board->counts ) );
    }

    /**
     * @depends testCreate
     */
    public function testDelete($board_id)
    {
        $board = $this->pinterest->boards->delete($board_id);

        $this->assertInstanceOf( 'DirkGroenen\Pinterest\Models\Board', $board );
    }

}