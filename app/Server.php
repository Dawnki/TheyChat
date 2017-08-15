<?php
/**
 * Created by PhpStorm.
 * User: dawnki
 * Date: 17-8-15
 * Time: 下午10:56
 */

namespace App;

use App\callback\onClose;
use App\callback\onConnect;
use App\callback\onReceive;
use App\callback\onStart;
use App\callback\onWorkStart;
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
        $this->server->on('start', [onStart::class, 'run']);
        $this->server->on('connect', [onConnect::class, 'run']);
        $this->server->on('receive', [onReceive::class, 'run']);
        $this->server->on('close', [onClose::class, 'run']);
        $this->server->on('WorkerStart', [onWorkStart::class, 'run']);
    }

    private function setting()
    {
        $this->server->set([
            'worker_num' => WORKER_NUM,
            'daemonize' => IS_DAEMON,
            'open_mqtt_protocol' => OPEN_MQTT,
            'max_request' => MAX_REQUEST,
            'dispatch_mode' => DISPATCH_MOD
        ]);
    }
}