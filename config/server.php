<?php
/**
 * Created by PhpStorm.
 * User: dawnki
 * Date: 17-8-15
 * Time: 下午11:05
 */
//服务器IP
define('SERVER_IP','127.0.0.1');
//服务器端口
define('SERVER_PORT','9999');
//工作进程数
define('WORKER_NUM',4);
//是否纳入守护进程
define('IS_DAEMON',false);
//是否开启MQTT协议
define('OPEN_MQTT',true);
//1 轮循 2 固定 3 抢占 4 IP分配 5 UID分配
define('DISPATCH_MOD',2);
//最大请求数
define('MAX_REQUEST',10000);