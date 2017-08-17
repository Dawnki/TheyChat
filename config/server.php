<?php
/**
 * Created by PhpStorm.
 * User: dawnki
 * Date: 17-8-15
 * Time: 下午11:05
 */

return [
    //服务器IP
    'SERVER_IP' => '127.0.0.1',
    //服务器端口
    'SERVER_PORT' => 9999,
    //工作进程数
    'WORKER_NUM' => 4,
    //task数
    'TASK_NUM' => 2,
    //是否纳入守护进程
    'IS_DAEMON' => false,
    //是否开启MQTT协议
    'OPEN_MQTT' => true,
    //1 轮循 2 固定 3 抢占 4 IP分配 5 UID分配
    'DISPATCH_MOD' => 2,
    //最大请求数
    'MAX_REQUEST' => 10000

];