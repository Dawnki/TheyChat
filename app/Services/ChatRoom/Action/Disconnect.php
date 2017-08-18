<?php
/**
 * Created by PhpStorm.
 * User: dawnki
 * Date: 17-8-18
 * Time: 上午10:35
 */

namespace App\Services\ChatRoom\Action;


class Disconnect extends abstractAction
{
    public function handle()
    {
        logger("fd:{$this->manage->fd} 发起了断连操作,执行断连!");
        $this->manage->server->close($this->manage->fd);
    }
}