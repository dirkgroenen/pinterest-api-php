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
     * @param  string   $value
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

        if(ini_get("open_basedir") == "" && ini_get("safe_mode" == "Off")){
            curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, $mr > 0);
            curl_setopt($this->curl, CURLOPT_MAXREDIRS, $mr);
        }
        else{
            $this->setOption(CURLOPT_FOLLOWLOCATION, false);

            if($mr > 0){
                $original_url = $this->getInfo(CURLINFO_EFFECTIVE_URL);
                $newurl = $original_url;

                $rch = curl_copy_handle($this->curl);

                curl_setopt($rch, CURLOPT_HEADER, true);
                curl_setopt($rch, CURLOPT_NOBODY, true);
                curl_setopt($rch, CURLOPT_FORBID_REUSE, false);

                do{
                    curl_setopt($rch, CURLOPT_URL, $newurl);
                    $header = curl_exec($rch);

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
                    if ($maxredirect === null){
                        trigger_error('Too many redirects.', E_USER_WARNING);
                    }
                    else{
                        $maxredirect = 0;
                    }

                    return false;
                }
                $this->setOption(CURLOPT_URL, $newurl);
            }
        }

        return curl_exec($this->curl);
    }
}