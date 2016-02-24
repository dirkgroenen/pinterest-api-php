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

use DirkGroenen\Pinterest\Endpoints\Boards;

class User extends Model {
        
    /**
     * The available object keys
     * 
     * @var array
     */
    protected $fillable = ["id", "username", "first_name", "last_name", "bio", "created_at", "counts", "image", "url", "account_type"];

}
