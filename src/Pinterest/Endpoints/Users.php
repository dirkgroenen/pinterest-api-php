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
     * @return Models\User
     */
    public function me()
    {
        $user = $this->request->get("me");
        return new User( $user );
    }

    /**
     * Get the provided user
     * 
     * @access public
     * @param string    $username
     * @return Models\User
     */
    public function find($username)
    {
        $user = $this->request->get( sprintf("users/%s", $username) );
        return new User( $user );
    }

    /**
     * Get the authenticated user's pins
     * 
     * @access public
     * @return Collection
     */
    public function getMePins()
    {
        $pins = $this->request->get( "me/pins" );
        return new Collection( $pins, "Pin" );
    }

    /**
     * Get the authenticated user's boards
     * 
     * @access public
     * @return Collection
     */
    public function getMeBoards()
    {
        $boards = $this->request->get( "me/boards" );
        return new Collection( $boards, "Board" );
    }

    /**
     * Get the authenticated user's likes
     * 
     * @access public
     * @return Collection
     */
    public function getMeLikes()
    {
        $likes = $this->request->get( "me/likes" );
        return new Collection( $likes, "Like" );
    }

    /**
     * Get the authenticated user's following users
     * 
     * @access public
     * @return Collection
     */
    public function getMeFollowingUsers()
    {
        $users = $this->request->get( "me/following/users" );
        return new Collection( $users, "User" );
    }

    /**
     * Get the authenticated user's following boards
     * 
     * @access public
     * @return Collection
     */
    public function getMeFollowingBoards()
    {
        $boards = $this->request->get( "me/following/boards" );
        return new Collection( $boards, "Board" );
    }

    /**
     * Get the authenticated user's following interest
     * 
     * @access public
     * @return Collection
     */
    public function getMeFollowingInterest()
    {
        $interest = $this->request->get( "me/following/interest" );
        return new Collection( $interest, "Board" );
    }
    

    /**
     * Get the pins for the given user
     * 
     * @access public
     * @param string $username
     * @return Collection
     */
    public function getUserPins($username)
    {
        $pins = $this->request->get( sprintf("users/%s/pins", $username) );
        return new Collection( $pins, "Pin" );
    }


}