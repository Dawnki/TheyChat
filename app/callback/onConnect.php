<?php
/**
 * Created by PhpStorm.
 * User: dawnki
 * Date: 17-8-15
 * Time: 下午11:46
 */

namespace App\callback;


use App\Services\Storage\Redis;

class onConnect
{
    /**
     * @var Redis
     */
    protected $storage;

    public function __construct()
    {
        $this->storage = app('storage');
    }

    /**
     * @param $server \swoole_server
     * @param $fd integer
     * @param $from_id
     */
    public function run($server, $fd, $from_id)
    {
        logger('fd:' . $fd . ' is connecting!');
    }
}