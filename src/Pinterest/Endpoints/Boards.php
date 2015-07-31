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

use DirkGroenen\Pinterest\Models\Board;
use DirkGroenen\Pinterest\Models\Collection;

class Boards extends Endpoint {

    /**
     * Find the provided board
     * 
     * @access public
     * @param string    $board_id
     * @return Models\Board
     */
    public function find($board_id)
    {
        $board = $this->request->get( sprintf("boards/%s", $board_id) );
        return new Board( $board );
    }
}