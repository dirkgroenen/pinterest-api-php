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

class SectionsTest extends \PHPUnit\Framework\TestCase
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
        $response = $this->pinterest->sections->get("503066289565421201");

        $this->assertInstanceOf("DirkGroenen\Pinterest\Models\Collection", $response);
        $this->assertInstanceOf("DirkGroenen\Pinterest\Models\Section", $response->get(0));
        $this->assertEquals($response->get(0)->id, "<BoardSection 5027629787972154693>");
    }

    public function testPins()
    {
        $response = $this->pinterest->sections->pins("503066289565421201");

        $this->assertInstanceOf("DirkGroenen\Pinterest\Models\Collection", $response);
        $this->assertInstanceOf("DirkGroenen\Pinterest\Models\Pin", $response->get(0));
    }

    public function testCreate()
    {
        $response = $this->pinterest->sections->create("503066289565421205", array(
            "title" => "Test from API"
        ));

        $this->assertInstanceOf("DirkGroenen\Pinterest\Models\Section", $response);
        $this->assertEquals($response->id, "<BoardSection 5027630990032422748>");
    }

    public function testDelete()
    {
        $response = $this->pinterest->sections->delete("5027630990032422748");

        $this->assertTrue($response);
    }
}
