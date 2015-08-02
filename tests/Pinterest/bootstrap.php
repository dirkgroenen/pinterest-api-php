<?php 
/**
 * Copyright 2015 Dirk Groenen 
 *
 * (c) Dirk Groenen <dirk@bitlabs.nl>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require __DIR__ . "/../../vendor/autoload.php";

define('CLIENT_ID', getenv('CLIENT_ID'));
define('CLIENT_SECRET', getenv('CLIENT_SECRET'));
define('ACCESS_TOKEN', getenv('ACCESS_TOKEN'));
define('CALLBACK_URL', getenv('CALLBACK_URL'));