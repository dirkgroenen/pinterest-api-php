<?php 
/**
 * Copyright 2015 Dirk Groenen 
 *
 * (c) Dirk Groenen <dirk@bitlabs.nl>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DirkGroenen\Pinterest\Models;

class Section extends Model {
        
    /**
     * The available object keys
     * 
     * @see https://developers.pinterest.com/docs/api/sections/?
     * 
     * @var array
     */
    protected $fillable = ["id", "title"];

}
