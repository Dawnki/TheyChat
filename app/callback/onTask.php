<?php
/**
 * Created by PhpStorm.
 * User: dawnki
 * Date: 17-8-16
 * Time: 上午9:25
 */

namespace App\callback;


class onTask
{
    /**
     *  非阻塞广播内容
     * @param $server \swoole_server
     * @param $task_id
     * @param $from_id
     * @param $data
     */
    public function run($server, $task_id, $from_id, $data)
    {
        if (!isset($data['content']) || !isset($data['fds'])) {
            logger('投递的数据包有误,缺失content或者fds', 'Exception');
            return;
        }
        $content = $data['content'];
        $fds = $data['fds'];
        foreach ($fds as $fd) {
            logger('send fd:'.$fd.' content:'.$content);
            $server->send($fd, $content);
        }
        $server->finish('success');
    }
}