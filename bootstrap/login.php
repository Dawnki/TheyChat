<?php
/**
 * Created by PhpStorm.
 * User: dawnki
 * Date: 17-8-16
 * Time: 下午3:43
 */

require_once __DIR__ . "/../vendor/autoload.php";

require_once __DIR__ . "/../config/http.php";

require_once __DIR__ . "/../tools/helper.php";


$GLOBALS['container'] = require_once __DIR__ . "/../tools/container.php";

//注册对象

$Server = $GLOBALS['container']->make('HTTP');

$Server->start();