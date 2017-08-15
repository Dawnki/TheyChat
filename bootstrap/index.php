<?php
/**
 * Created by PhpStorm.
 * User: dawnki
 * Date: 17-8-15
 * Time: 下午10:38
 */

require_once __DIR__ . "/../vendor/autoload.php";

require_once __DIR__ . "/../config/server.php";

require_once __DIR__ . "/helper.php";

use App\Server;

//注册对象

$Server = new Server();

$Server->start();