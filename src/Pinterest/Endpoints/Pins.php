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

use DirkGroenen\Pinterest\Models\Pin;
use DirkGroenen\Pinterest\Models\Collection;

class Pins extends Endpoint {
    
    /**
     * Get a pin object
     * 
     * @access public
     * @param  string   $pin_id
     * @param array     $data
     * @throws Exceptions/PinterestExceptions
     * @return Models\Pin
     */
    public function get( $pin_id, array $data = [] )
    {
        $pin = $this->request->get( sprintf("pins/%s", $pin_id), $data );
        return new Pin( $this->master, $pin );
    }

    /**
     * Get all pins from the given board
     * 
     * @access public
     * @param  string   $board_id
     * @param array     $data
     * @throws Exceptions/PinterestExceptions
     * @return Models\Collection
     */
    public function fromBoard( $board_id, array $data = [] )
    {
        $pins = $this->request->get( sprintf("boards/%s/pins", $board_id), $data );
        return new Collection( $this->master, $pins, "Pin" );
    }

    /**
     * Create a pin
     *
     * @access public
     * @param  array    $data
     * @throws Exceptions/PinterestExceptions
     * @return Models\Pin
     */
    public function create( array $data )
    {
        $pin = $this->request->post( "pins", $data );
        return new Pin( $this->master, $pin );
    }

    /**
     * Update a pin
     *
     * @access public
     * @param  string   $pin_id
     * @param  array    $data
     * @throws Exceptions/PinterestExceptions
     * @return Models\Pin
     */
    public function update( $pin_id, array $data )
    {
        $pin = $this->request->update( sprintf("pins/%s", $pin_id), $data );
        return new Pin( $this->master, $pin );
    }

    /**
     * Delete a pin
     *
     * @access public
     * @param  string   $pin_id
     * @throws Exceptions/PinterestExceptions
     * @return Models\Pin
     */
    public function delete( $pin_id )
    {
        $pin = $this->request->delete( sprintf("pins/%s", $pin_id) );
        return new Pin( $this->master, $pin );
    }
}