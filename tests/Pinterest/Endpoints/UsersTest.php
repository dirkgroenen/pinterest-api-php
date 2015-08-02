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

class UsersTest extends \PHPUnit_Framework_TestCase{
    
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

    public function testUsersEndpointExistence()
    {
        $this->assertInstanceOf( 'DirkGroenen\Pinterest\Endpoints\Users', $this->pinterest->users );
    }

    public function testMe()
    {
        $user = $this->pinterest->users->me();

        $this->assertInstanceOf( 'DirkGroenen\Pinterest\Models\User', $user );
        $this->assertEquals( $user->id , "503066358284560467" );   
    }

    public function testFind()
    {
        $user = $this->pinterest->users->find("ben");

        $this->assertInstanceOf( 'DirkGroenen\Pinterest\Models\User', $user );
        $this->assertEquals( $user->id , "422418623496193" );   
    }

    public function testGetMePins()
    {
        $pins = $this->pinterest->users->getMePins();

        $this->assertInstanceOf( 'DirkGroenen\Pinterest\Models\Collection', $pins );
        $this->assertInstanceOf( 'DirkGroenen\Pinterest\Models\Pin', $pins->get(0) );
    }

    public function testGetMePinsWithExtraFields()
    {
        $pins = $this->pinterest->users->getMePins(array(
            "fields"    => "image[large]"
        ));

        $this->assertTrue( is_array( $pins->get(0)->image ) );
    }

    public function testSearchMePins()
    {
        $pins = $this->pinterest->users->searchMePins( "cat" );

        $this->assertInstanceOf( 'DirkGroenen\Pinterest\Models\Collection', $pins );
    }
    
    public function testSearchMeBoards()
    {
        $boards = $this->pinterest->users->searchMeBoards( "web" );

        $this->assertInstanceOf( 'DirkGroenen\Pinterest\Models\Collection', $boards );
    }

    public function testGetMeBoards()
    {
        $boards = $this->pinterest->users->getMeBoards();

        $this->assertInstanceOf( 'DirkGroenen\Pinterest\Models\Collection', $boards );
        $this->assertInstanceOf( 'DirkGroenen\Pinterest\Models\Board', $boards->get(0) );
    }


    public function testGetMeLikes()
    {
        $likes = $this->pinterest->users->getMeLikes();

        $this->assertInstanceOf( 'DirkGroenen\Pinterest\Models\Collection', $likes );
        $this->assertInstanceOf( 'DirkGroenen\Pinterest\Models\Pin', $likes->get(0) );
    }

}