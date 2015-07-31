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
     * @return Models\Pin
     */
    public function get($pin_id)
    {
        $pin = $this->request->get( sprintf("pins/%s/", $pin_id) );
        return new Pin( $pin );
    }

    /**
     * Get all pins from the given board
     * 
     * @access public
     * @param  string   $board_id
     * @return Models\Collection
     */
    public function fromBoard($board_id)
    {
        $pins = $this->request->get( sprintf("boards/%s/pins/", $board_id) );
        return new Collection( $pins, "Pin" );
    }
}