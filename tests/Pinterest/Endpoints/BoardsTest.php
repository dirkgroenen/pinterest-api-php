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

class BoardsTest extends \PHPUnit\Framework\TestCase
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

    public function testGet()
    {
        $response = $this->pinterest->boards->get("503066289565421201");

        $this->assertInstanceOf("DirkGroenen\Pinterest\Models\Board", $response);
        $this->assertEquals($response->id, "503066289565421201");
    }

    public function testGetWithExtraFields()
    {
        $response = $this->pinterest->boards->get("503066289565421201", array(
            "fields" => "url,description,creator,counts"
        ));

        $this->assertInstanceOf("DirkGroenen\Pinterest\Models\Board", $response);
        $this->assertTrue(isset($response->creator['first_name']));
    }

    public function testCreate()
    {
        $response = $this->pinterest->boards->create(array(
            "name"          => "Test board from API",
            "description"   => "Test Board From API Test"
        ));

        $this->assertInstanceOf("DirkGroenen\Pinterest\Models\Board", $response);
        $this->assertEquals($response->id, "503066289565421205");
    }

    public function testEdit()
    {
        $response = $this->pinterest->boards->edit("503066289565421201", array(
            "name"          => "Test board from API"
        ));

        $this->assertInstanceOf("DirkGroenen\Pinterest\Models\Board", $response);
        $this->assertEquals($response->id, "503066289565421205");
    }

    public function testDelete()
    {
        $response = $this->pinterest->boards->delete("503066289565421205");

        $this->assertTrue($response);
    }
}
