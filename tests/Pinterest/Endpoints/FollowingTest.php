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

class FollowingTest extends \PHPUnit_Framework_TestCase{
    
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

    public function testFollowingEndpointExistence()
    {
        $this->assertInstanceOf( 'DirkGroenen\Pinterest\Endpoints\Following', $this->pinterest->following );
    }

    public function testGetUsers()
    {
        $users = $this->pinterest->following->users();

        $this->assertInstanceOf( 'DirkGroenen\Pinterest\Models\Collection', $users );
        $this->assertInstanceOf( 'DirkGroenen\Pinterest\Models\User', $users->get(0) );

        return $users->get(0)->id;
    }

    /**
     * @depends testGetUsers
     */
    public function testUnfollowUser($user_id)
    {
        $response = $this->pinterest->following->unfollowUser($user_id);

        $this->assertTrue($response);
    }

    /**
     * @depends testGetUsers
     */
    public function testFollowUser($user_id)
    {
        $response = $this->pinterest->following->followUser($user_id);

        $this->assertTrue($response);
    }

    public function testGetBoards()
    {
        $boards = $this->pinterest->following->boards();

        $this->assertInstanceOf( 'DirkGroenen\Pinterest\Models\Collection', $boards );
        $this->assertInstanceOf( 'DirkGroenen\Pinterest\Models\Board', $boards->get(0) );

        return $boards->get(0)->id;
    }

    /**
     * @depends testGetBoards
     */
    public function testUnfollowBoard($board_id)
    {
        $response = $this->pinterest->following->unfollowBoard($board_id);

        $this->assertTrue($response);
    }

    /**
     * @depends testGetBoards
     */
    public function testFollowBoard($board_id)
    {
        $response = $this->pinterest->following->followBoard($board_id);

        $this->assertTrue($response);
    }

    public function testGetInterests()
    {
        $interests = $this->pinterest->following->interests();

        $this->assertInstanceOf( 'DirkGroenen\Pinterest\Models\Collection', $interests );
        $this->assertInstanceOf( 'DirkGroenen\Pinterest\Models\Model', $interests->get(0) );

        return $interests->get(0)->id;
    }


}