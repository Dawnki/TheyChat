<?php
/**
 * Created by PhpStorm.
 * User: dawnki
 * Date: 17-8-17
 * Time: 下午4:22
 */

namespace App\Services\Storage;


use Predis\Client;

class Redis
{
    protected $client;

    protected $redis_config;

    public function __construct()
    {
        $this->redis_config = config('redis');
        $setting = [
            'host' => $this->redis_config['REDIS_IP'],
            'port' => $this->redis_config['REDIS_PORT']
        ];
        $this->client = new Client($setting);
    }

    public function __call($func_name, $argv)
    {
        return call_user_func_array([$this->client, $func_name], $argv);
    }
}