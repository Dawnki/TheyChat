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
    protected $storage;

    public function __construct()
    {
        $this->storage=app('storage');
    }

    public function run($server, $fd, $reactor_id)
    {
        $prefix=config('redis')['PREFIX']['connection'];
        $this->storage->del($prefix.$fd);
        logger('fd:'.$fd.' has been disconnected!');
    }
}