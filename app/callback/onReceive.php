<?php
/**
 * Created by PhpStorm.
 * User: dawnki
 * Date: 17-8-15
 * Time: 下午11:47
 */

namespace App\callback;


use App\Services\ChatRoom\ChatManage;

class onReceive
{

    protected $manage;

    public function __construct(ChatManage $manage)
    {
        $this->manage=$manage;
    }

    public function run($server, $fd, $reactor_id, $data)
    {
        $this->manage->bootstrap($server, $fd, $reactor_id, $data);
    }
}