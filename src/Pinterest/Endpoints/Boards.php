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
     * @param  array     $data
     * @throws \DirkGroenen\Pinterest\Exceptions\PinterestException
     * @return Collection
     */
    public function listBoards(array $data = [])
    {
        $response = $this->request->get("boards", $data);
        return new Collection($this->master, $response, "Board");
    }

    /**
     * Find the provided board
     *
     * @access public
     * @param  string    $boardId
     * @param  array     $data
     * @throws \DirkGroenen\Pinterest\Exceptions\PinterestException
     * @return Board
     */
    public function get($boardId, array $data = [])
    {
        $response = $this->request->get(sprintf("boards/%s", $boardId), $data);
        return new Board($this->master, $response);
    }

    /**
     * Create a new board
     *
     * @access public
     * @param  array    $data
     * @throws \DirkGroenen\Pinterest\Exceptions\PinterestException
     * @return Board
     */
    public function create(array $data)
    {
        $response = $this->request->post("boards", $data);
        return new Board($this->master, $response);
    }

    /**
     * Edit a board
     *
     * @access public
     * @param  string   $boardId
     * @param  array    $data
     * @param  string   $fields
     * @throws \DirkGroenen\Pinterest\Exceptions\PinterestException
     * @return Board
     */
    public function edit($boardId, array $data, $fields = null)
    {
        $query = (!$fields) ? array() : array("fields" => $fields);

        $response = $this->request->update(sprintf("boards/%s", $boardId), $data, $query);
        return new Board($this->master, $response);
    }

    /**
     * Get pins for section
     *
     * @access public
     * @param  string   $boardId
     * @param  array    $data
     * @throws \DirkGroenen\Pinterest\Exceptions\PinterestException
     * @return Collection<Pin>
     */
    public function pins(string $boardId, array $data = [])
    {
        $response = $this->request->get(sprintf("boards/%s/pins", $boardId), $data);
        return new Collection($this->master, $response, "Pin");
    }

    /**
     * Delete a board
     *
     * @access public
     * @param  string    $boardId
     * @throws \DirkGroenen\Pinterest\Exceptions\PinterestException
     * @return boolean
     */
    public function delete($boardId)
    {
        $this->request->delete(sprintf("boards/%s", $boardId));
        return true;
    }
}