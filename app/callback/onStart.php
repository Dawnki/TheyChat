<?php
/**
 * Created by PhpStorm.
 * User: dawnki
 * Date: 17-8-15
 * Time: 下午11:45
 */

namespace App\callback;


class onStart
{
    public static function run($server)
    {
        logger('Server is starting!');
    }
}