<?php
/**
 * Created by PhpStorm.
 * User: dawnki
 * Date: 17-8-16
 * Time: 上午9:43
 */

$container = new \Illuminate\Container\Container();

//bind Server
$container->singleton('SERVER', \App\Server::class);

//bind CallBack function
$container->bind('close',\App\callback\onClose::class);
$container->bind('connect',\App\callback\onConnect::class);
$container->bind('finish',\App\callback\onFinish::class);
$container->bind('receive',\App\callback\onReceive::class);
$container->bind('start',\App\callback\onStart::class);
$container->bind('task',\App\callback\onTask::class);
$container->bind('WorkStart',\App\callback\onWorkStart::class);


return $container;