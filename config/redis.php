<?php
/**
 * Created by PhpStorm.
 * User: dawnki
 * Date: 17-8-16
 * Time: 下午12:04
 */

return [
    //redis服务器ip
    'REDIS_IP' => '172.7.0.2',
    //redis服务器端口
    'REDIS_PORT' => '6379',
    //redis模块
    'PREFIX' => [
        'login' => 'TheyChat:Login:ID:',
        'token' => 'TheyChat:Token:ID:',
        'connection' => 'TheyChat:Connection:ID:',
        'fd_connection' => 'TheyChat:Connection:FD:',
    ]
];