<?php
/**
 * Created by PhpStorm.
 * User: dawnki
 * Date: 17-8-15
 * Time: 下午11:45
 */

namespace App\callback;


class onClose
{
    public function run($server, $fd, $reactor_id)
    {
        logger('fd:'.$fd.' has been disconnected!');
    }
}