<?php
/**
 * Copyright 2015 Dirk Groenen
 *
 * (c) Dirk Groenen <dirk@bitlabs.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DirkGroenen\Pinterest\Endpoints;

use DirkGroenen\Pinterest\Models\User;
use DirkGroenen\Pinterest\Models\Collection;

class Users extends Endpoint {

    /**
     * Get the current user
     *
     * @access public
     * @param array     $data
     * @throws Exceptions/PinterestExceptions
     * @return User
     */
    public function me(array $data = [])
    {
        $response = $this->request->get("me/", $data);
        return new User($this->master, $response);
    }

    /**
     * Get the provided user
     *
     * @access public
     * @param string    $username
     * @param array     $data
     * @throws Exceptions/PinterestExceptions
     * @return User
     */
    public function find($username, array $data = [])
    {
        $response = $this->request->get(sprintf("users/%s/", $username), $data);
        return new User($this->master, $response);
    }

    /**
     * Get the authenticated user's pins
     *
     * @access public
     * @param array     $data
     * @throws Exceptions/PinterestExceptions
     * @return Collection
     */
    public function getMePins(array $data = [])
    {
        $response = $this->request->get("me/pins/", $data);
        return new Collection($this->master, $response, "Pin");
    }

    /**
     * Search in the user's pins
     *
     * @param  string   $query
     * @param  array    $data
     * @throws Exceptions/PinterestExceptions
     * @return Collection
     */
    public function searchMePins($query, array $data = [])
    {
        $data["query"] = $query;
        $response = $this->request->get("me/search/pins/", $data);
        return new Collection($this->master, $response, "Pin");
    }

    /**
     * Search in the user's boards
     *
     * @param  string   $query
     * @param  array    $data
     * @throws Exceptions/PinterestExceptions
     * @return Collection
     */
    public function searchMeBoards($query, array $data = [])
    {
        $data["query"] = $query;

        $response = $this->request->get("me/search/boards/", $data);
        return new Collection($this->master, $response, "Board");
    }

    /**
     * Get the authenticated user's boards
     *
     * @access public
     * @param array     $data
     * @throws Exceptions/PinterestExceptions
     * @return Collection
     */
    public function getMeBoards(array $data = [])
    {
        $response = $this->request->get("me/boards/", $data);
        return new Collection($this->master, $response, "Board");
    }

    /**
     * Get the authenticated user's likes
     *
     * @access public
     * @param array     $data
     * @throws Exceptions/PinterestExceptions
     * @return Collection
     */
    public function getMeLikes(array $data = [])
    {
        $response = $this->request->get("me/likes/", $data);
        return new Collection($this->master, $response, "Pin");
    }

    /**
     * Get the authenticated user's followers
     *
     * @access public
     * @param array     $data
     * @throws Exceptions\PinterestException
     * @return Collection
     */
    public function getMeFollowers(array $data = [])
    {
        $response = $this->request->get("me/followers/", $data);
        return new Collection($this->master, $response, "User");
    }

}
