<?php
/**
 * Created by PhpStorm.
 * User: dawnki
 * Date: 17-8-16
 * Time: 下午3:45
 */

namespace App;


class Http
{
    private $http;

    private $config;

    public function __construct()
    {
        $this->config = config('http');
        $this->http = new \swoole_http_server($this->config['SERVER_IP'], $this->config['SERVER_PORT']);
    }

    public function start()
    {
        $this->config();
        $this->registerCallBack();
        $this->http->start();
    }

    private function registerCallBack()
    {
        $method = 'run';
        $this->http->on('request', [app('request'), $method]);
    }

    private function config()
    {
        $this->http->set([
            'worker_num' => $this->config['WORKER_NUM'],
            'daemonize' => $this->config['IS_DAEMON'],
            'max_request' => $this->config['MAX_REQUEST'],
            'dispatch_mode' => $this->config['DISPATCH_MOD'],
            //'task_worker_num' => $this->config['TASK_NUM']
        ]);
    }
}