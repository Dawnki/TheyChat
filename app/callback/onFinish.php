<?php
/**
 * Created by PhpStorm.
 * User: dawnki
 * Date: 17-8-16
 * Time: 上午9:29
 */

namespace App\callback;


class onFinish
{
    public function run($server, $task_id, $data)
    {
        logger("群发状态: {$data}");
    }
}