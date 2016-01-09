<?php
/**
 * Copyright 2015 Dirk Groenen
 *
 * (c) Dirk Groenen <dirk@bitlabs.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DirkGroenen\Pinterest\Utils;

use DirkGroenen\Pinterest\Exceptions\PinterestException;

class CurlBuilder {

    /**
     * Contains the curl instance
     *
     * @var resource
     */
    private $curl;

    /**
     * Array containing headers from last performed request
     *
     * @var array
     */
    private $headers;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->curl = curl_init();
    }

    /**
     * Return a new instance of the CurlBuilder
     *
     * @access public
     * @return CurlBuilder
     */
    public function create()
    {
        return new self();
    }

    /**
     * Sets an option in the curl instance
     *
     * @access public
     * @param  string   $option
     * @param  mixed    $value
     * @return $this
     */
    public function setOption( $option, $value )
    {
        curl_setopt($this->curl, $option, $value );

        return $this;
    }

    /**
     * Sets multiple options at the same time
     *
     * @access public
     * @param  array   $options
     * @return $this
     */
    public function setOptions( array $options = [] )
    {
        curl_setopt_array($this->curl, $options);

        return $this;
    }

    /**
     * Execute the curl request
     *
     * @access public
     * @return mixed
     */
    public function execute()
    {
        return $this->execFollow();
    }

    /**
     * Check if the curl request ended up with errors
     *
     * @access public
     * @return boolean
     */
    public function hasErrors()
    {
        return curl_errno($this->curl);
    }

    /**
     * Get curl errors
     *
     * @access public
     * @return string
     */
    public function getErrors()
    {
        return curl_error($this->curl);
    }

    /**
     * Get last curl error number
     *
     * @access public
     * @return int
     */
    public function getErrorNumber()
    {
        return curl_errno($this->curl);
    }

    /**
     * Get curl info key
     *
     * @access public
     * @param  string  $key
     * @return string
     */
    public function getInfo($key)
    {
        return curl_getinfo($this->curl, $key);
    }

    /**
     * Get headers
     *
     * @access public
     * @return string
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Close the curl resource
     *
     * @access public
     * @return void
     */
    public function close()
    {
        curl_close($this->curl);
    }

    /**
     * Parse string headers into array
     *
     * @access private
     * @param array $headers
     * @return array
     */
    private function parseHeaders($headers) {
        $result = array();
        foreach(explode("\n", $headers) as $row){
            $header = explode(':', $row, 2);
            if (count($header) == 2)
                $result[$header[0]] = trim($header[1]);
            else
                $result[] = $header[0];
        }
        return $result;
    }

    /**
     * Function which acts as a replacement for curl's default
     * FOLLOW_LOCATION option, since that gives errors when
     * combining it with open basedir.
     *
     * @see http://slopjong.de/2012/03/31/curl-follow-locations-with-safe_mode-enabled-or-open_basedir-set/
     * @access private
     * @return mixed
     */
    private function execFollow() {
        $mr = 5;
        $body = null;

        if(ini_get("open_basedir") == "" && ini_get("safe_mode" == "Off")){
            curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, $mr > 0);
            curl_setopt($this->curl, CURLOPT_MAXREDIRS, $mr);
        }
        else{
            $this->setOption(CURLOPT_FOLLOWLOCATION, false);

            if($CURLOPT_MAXREDIRS  > 0){
                $original_url = $this->getInfo(CURLINFO_EFFECTIVE_URL);
                $newurl = $original_url;

                $rch = curl_copy_handle($this->curl);

                curl_setopt($rch, CURLOPT_HEADER, true);
                curl_setopt($rch, CURLOPT_FORBID_REUSE, false);

                do{
                    curl_setopt($rch, CURLOPT_URL, $newurl);
                    $response = curl_exec($rch);

                    $header_size = curl_getinfo($rch, CURLINFO_HEADER_SIZE);
                    $header = substr($response, 0, $header_size);
                    $body = substr($response, $header_size);

                    if(curl_errno($rch)){
                        $code = 0;
                    }
                    else{
                        $code = curl_getinfo($rch, CURLINFO_HTTP_CODE);

                        if ($code == 301 || $code == 302) {
                            preg_match('/Location:(.*?)\n/i', $header, $matches);
                            $newurl = trim(array_pop($matches));
                        }
                        else{
                            $code = 0;
                        }
                    }
                } while($code && --$mr);

                curl_close($rch);

                if(!$mr){
                    if ($mr === null){
                        trigger_error('Too many redirects.', E_USER_WARNING);
                    }

                    return false;
                }
                $this->setOption(CURLOPT_URL, $newurl);

                $this->headers = $this->parseHeaders($header);
            }
        }

        if (!$body){
            curl_setopt($this->curl, CURLOPT_HEADER, true);
            $response = curl_exec($this->curl);

            $header_size = curl_getinfo($rch, CURLINFO_HEADER_SIZE);
            $header = substr($response, 0, $header_size);
            $body = substr($response, $header_size);

            $this->headers = $this->parseHeaders($header);
        }

        return $body;
    }
}