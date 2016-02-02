<?php
/**
 * Copyright 2015 Dirk Groenen
 *
 * (c) Dirk Groenen <dirk@bitlabs.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DirkGroenen\Pinterest\Transport;

use DirkGroenen\Pinterest\Utils\CurlBuilder;

    /**
     * @property array $page
     * @property array $data
     * @property string $message
     */
class Response {

    /**
     * Contains the raw response
     *
     * @var string
     */
    private $response;

    /**
     * Used curl instance
     *
     * @var curl
     */
    private $curl;

    /**
     * Constructor
     *
     * @param  string        $response
     * @param  CurlBuilder  $curl
     * @param  curl    $curl
     */
    public function __construct($response, CurlBuilder $curl)
    {
        $this->response = $response;
        $this->curl = $curl;

        if (is_string($response)) {
            $this->response = $this->decodeString($response);
        }
    }

    /**
     * Decode the string to an array
     *
     * @access private
     * @param  string $response
     * @return array
     */
    private function decodeString($response)
    {
        return json_decode($response, true);
    }

    /**
     * Return the requested key data
     *
     * @access public
     * @param  string   $key
     * @return array
     */
    public function __get($key)
    {
        return isset($this->response[$key]) ? $this->response[$key] : [];
    }

    /**
     * Return if the key is set
     *
     * @access public
     * @param  string   $key
     * @return boolean
     */
    public function __isset($key)
    {
        return isset($this->response[$key]);
    }

    /**
     * Returns the error message which should normaly
     * by located in the response->message key, but can
     * also be localed in the response->error key.
     *
     * @return string
     */
    public function getMessage()
    {
        return (isset($this->message)) ? $this->message : $this->error;
    }

    /**
     * Get the response code from the request
     *
     * @access public
     * @return int
     */
    public function getResponseCode()
    {
        return $this->curl->getInfo(CURLINFO_HTTP_CODE);
    }

}