<?php
/**
 * Copyright 2015 Dirk Groenen
 *
 * (c) Dirk Groenen <dirk@bitlabs.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DirkGroenen\Pinterest\Tests\Utils;

class CurlBuilderMock {

    /**
     * Create a new mock of the curlbuilder and return
     * the given filename as content
     *
     * @access public
     * @param  PHPUnit_Framework_TestCase   $instance
     * @return mock
     */
    public static function create( $instance )
    {
        $reflection = new \ReflectionMethod( $instance, $instance->getName() );
        $doc_block  = $reflection->getDocComment();

        $responsefile = self::parseDocBlock( $doc_block, '@responsefile' );
        $responsecode = self::parseDocBlock( $doc_block, '@responsecode' );

        $defaultheaders = array(
            "X-Ratelimit-Limit" => "1000",
            "X-Ratelimit-Remaining" => "998",
            "X-Varnish" => "4059929980"
        );

        $skipmock = self::parseDocBlock( $doc_block, '@skipmock' );

        if(empty($responsecode))
            $responsecode = [201];

        if(empty($responsefile))
            $responsefile = [$instance->getName()];

        // Setup Curlbuilder mock
        $curlbuilder = $instance->getMockBuilder("\\DirkGroenen\\Pinterest\\Utils\\CurlBuilder")
                        ->getMock();

        $curlbuilder->expects($instance->any())
            ->method('create')
            ->will($instance->returnSelf());

        // Build response file path
        $responseFilePath = __DIR__ . '/../responses/' . (new \ReflectionClass($instance))->getShortName() . '/' . $responsefile[0] . ".json";

        if(file_exists($responseFilePath)){
            $curlbuilder->expects($instance->once())
                ->method('execute')
                ->will( $instance->returnValue( file_get_contents( $responseFilePath ) ) );
        }

        $curlbuilder->expects($instance->any())
            ->method('getInfo')
            ->will( $instance->returnValue( $responsecode[0] ) );

        return $curlbuilder;
    }

    /**
     * Parse the methods docblock and search for the
     * requested tag's value
     *
     * @access private
     * @param  string   $doc_block
     * @param  string   $tag
     * @return array
     */
    private static function parseDocBlock( $doc_block, $tag ) {

        $matches = array();

        if ( empty( $doc_block ) )
            return $matches;

        $regex = "/{$tag} (.*)(\\r\\n|\\r|\\n)/U";
        preg_match_all( $regex, $doc_block, $matches );

        if ( empty( $matches[1] ) )
            return array();

        // Removed extra index
        $matches = $matches[1];

        // Trim the results, array item by array item
        foreach ( $matches as $ix => $match )
            $matches[ $ix ] = trim( $match );

        return $matches;

    } // parseDocBlock
}