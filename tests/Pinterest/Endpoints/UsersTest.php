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

use \DirkGroenen\Pinterest\Pinterest;
use \DirkGroenen\Pinterest\Tests\Utils\CurlBuilderMock;

class UsersTest extends \PHPUnit\Framework\TestCase
{

    /**
     * The Pinterest instance
     *
     * @var Pinterest
     */
    private $pinterest;

    /**
     * Setup a new instance of the Pinterest class
     *
     * @return void
     */
    public function setUp(): void
    {
        $curlbuilder = CurlBuilderMock::create($this);

        // Setup Pinterest
        $this->pinterest = new Pinterest("0", "0", $curlbuilder);
        $this->pinterest->auth->setOAuthToken("0");
    }

    public function testMe()
    {
        $response = $this->pinterest->users->me();

        $this->assertInstanceOf("DirkGroenen\Pinterest\Models\User", $response);
        $this->assertEquals($response->id, "503066358284560467");
    }

    public function testFindValidUser()
    {
        $response = $this->pinterest->users->find('dirkgroenen');

        $this->assertInstanceOf("DirkGroenen\Pinterest\Models\User", $response);
        $this->assertEquals($response->id, "503066358284560467");
    }

    /**
     * @responsecode            404
     */
    public function testFindInValidUserAndThrowException()
    {
        $this->expectException(\DirkGroenen\Pinterest\Exceptions\PinterestException::class);

        $this->pinterest->users->find('randomnonexistinguserwhichdoesntexist1234');
    }

    public function testGetMePins()
    {
        $response = $this->pinterest->users->getMePins();

        $this->assertInstanceOf("DirkGroenen\Pinterest\Models\Collection", $response);
        $this->assertInstanceOf("DirkGroenen\Pinterest\Models\Pin", $response->get(0));
        $this->assertEquals($response->get(0)->id, "503066220854919493");
    }

    public function testGetMePinsWithExtraFields()
    {
        $response = $this->pinterest->users->getMePins(array(
            "fields"    => "image[original,large,small]"
        ));

        $this->assertEquals($response->get(0)->image['small']['url'], "http://media-cache-ak0.pinimg.com/30x30/e1/4e/45/e14e4532c516e2c532744a6ad6d2d2d0.jpg");
    }

    public function testSearchMePins()
    {
        $response = $this->pinterest->users->searchMePins("design");

        $this->assertInstanceOf("DirkGroenen\Pinterest\Models\Collection", $response);
        $this->assertInstanceOf("DirkGroenen\Pinterest\Models\Pin", $response->get(0));
    }

    public function testSearchMeBoards()
    {
        $response = $this->pinterest->users->searchMeBoards("test");

        $this->assertInstanceOf("DirkGroenen\Pinterest\Models\Collection", $response);
        $this->assertInstanceOf("DirkGroenen\Pinterest\Models\Board", $response->get(0));
    }

    public function testGetMeBoards()
    {
        $response = $this->pinterest->users->getMeBoards();

        $this->assertInstanceOf("DirkGroenen\Pinterest\Models\Collection", $response);
        $this->assertInstanceOf("DirkGroenen\Pinterest\Models\Board", $response->get(0));
        $this->assertEquals($response->pagination, false);
    }

    public function testGetMeLikes()
    {
        $response = $this->pinterest->users->getMeLikes();

        $this->assertInstanceOf("DirkGroenen\Pinterest\Models\Collection", $response);
        $this->assertInstanceOf("DirkGroenen\Pinterest\Models\Pin", $response->get(0));
        $this->assertFalse($response->pagination);
    }

    public function testGetMeFollowers()
    {
        $response = $this->pinterest->users->getMeFollowers();

        $this->assertInstanceOf("DirkGroenen\Pinterest\Models\Collection", $response);
        $this->assertInstanceOf("DirkGroenen\Pinterest\Models\User", $response->get(0));
        $this->assertNotFalse($response->pagination);
    }
}
