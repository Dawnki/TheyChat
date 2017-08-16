<?php
/**
 * Created by PhpStorm.
 * User: dawnki
 * Date: 17-8-15
 * Time: 下午10:56
 */

namespace App;

use swoole_server;

class Server
{
    private $server;

    public function __construct()
    {
        $this->server = new swoole_server(SERVER_IP, SERVER_PORT);
    }

    public function start()
    {
        $this->setting();
        $this->registerCallBack();
        $this->server->start();
    }

    private function registerCallBack()
    {
        $method='run';
        $this->server->on('start', [app('start'), $method]);
        $this->server->on('connect', [app('connect'), $method]);
        $this->server->on('receive', [app('receive'), $method]);
        $this->server->on('close', [app('close'), $method]);
        $this->server->on('WorkerStart', [app('WorkStart'), $method]);
        $this->server->on('task', [app('task'), $method]);
        $this->server->on('finish', [app('finish'), $method]);

    }

    private function setting()
    {
        $this->server->set([
            'worker_num' => WORKER_NUM,
            'daemonize' => IS_DAEMON,
            'open_mqtt_protocol' => OPEN_MQTT,
            'max_request' => MAX_REQUEST,
            'dispatch_mode' => DISPATCH_MOD,
            'task_worker_num' => TASK_NUM
        ]);
    }
}