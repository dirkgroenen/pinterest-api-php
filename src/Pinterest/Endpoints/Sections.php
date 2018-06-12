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

use DirkGroenen\Pinterest\Models\Section;

class Sections extends Endpoint {

    public function get($section_id, array $data = [])
    {
        $response = $this->request->get(sprintf("boards/%s", $board_id), $data);
        return new Section($this->master, $response);
    }

    public function create($board_id, array $data)
    {
        $response = $this->request->post("boards/$board_id/sections", $data);
        return new Section($this->master, $response);
    }

    public function delete($section_id)
    {
        $this->request->delete(sprintf("boards/sectionis/%s", $section_id));
        return true;
    }
}