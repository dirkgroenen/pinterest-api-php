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

class Following extends Endpoint {


    /**
     * Get the authenticated user's following users
     *
     * @access public
     * @param array     $data
     * @throws Exceptions/PinterestExceptions
     * @return Collection
     */
    public function users(array $data = [])
    {
        $response = $this->request->get("me/following/users/", $data);
        return new Collection($this->master, $response, "User");
    }

    /**
     * Get the authenticated user's following boards
     *
     * @access public
     * @param array     $data
     * @throws Exceptions/PinterestExceptions
     * @return Collection
     */
    public function boards(array $data = [])
    {
        $response = $this->request->get("me/following/boards/", $data);
        return new Collection($this->master, $response, "Board");
    }

    /**
     * Get the authenticated user's following interest
     *
     * @access public
     * @param array     $data
     * @throws Exceptions/PinterestExceptions
     * @return Collection
     */
    public function interests(array $data = [])
    {
        $response = $this->request->get("me/following/interests/", $data);
        return new Collection($this->master, $response, "Interest");
    }

    /**
     * Follow a user
     *
     * @access public
     * @param  string $user
     * @throws Exceptions/PinterestExceptions
     * @return boolean
     */
    public function followUser($user)
    {
        $this->request->post("me/following/users/", array(
            "user"  => $user
        ));
        return true;
    }

    /**
     * Unfollow a user
     *
     * @access public
     * @param  string $user
     * @throws Exceptions/PinterestExceptions
     * @return boolean
     */
    public function unfollowUser($user)
    {
        $this->request->delete(sprintf("me/following/users/%s/", $user));
        return true;
    }

    /**
     * Follow a board
     *
     * @access public
     * @param  string $board
     * @throws Exceptions/PinterestExceptions
     * @return boolean
     */
    public function followBoard($board)
    {
        $this->request->post("me/following/boards/", array(
            "board"  => $board
        ));
        return true;
    }

    /**
     * Unfollow a board
     *
     * @access public
     * @param  string $board_id
     * @throws Exceptions/PinterestExceptions
     * @return boolean
     */
    public function unfollowBoard($board_id)
    {
        $this->request->delete(sprintf("me/following/boards/%s/", $board_id));
        return true;
    }

    /**
     * Follow a board
     *
     * @access public
     * @param  string $interest
     * @throws Exceptions/PinterestExceptions
     * @return boolean
     */
    public function followInterest($interest)
    {
        $this->request->post("me/following/interests/", array(
            "interest"  => $interest
        ));
        return true;
    }

    /**
     * Unfollow an interest
     *
     * @access public
     * @param  string $interest_id
     * @throws Exceptions/PinterestExceptions
     * @return boolean
     */
    public function unfollowInterest($interest_id)
    {
        $this->request->delete(sprintf("me/following/interests/%s/", $interest_id));
        return true;
    }
}