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
$container->singleton('HTTP',\App\Http::class);

//bind CallBack function
$container->singleton('close',\App\callback\onClose::class);
$container->singleton('connect',\App\callback\onConnect::class);
$container->singleton('finish',\App\callback\onFinish::class);
$container->singleton('receive',\App\callback\onReceive::class);
$container->singleton('start',\App\callback\onStart::class);
$container->singleton('task',\App\callback\onTask::class);
$container->singleton('WorkStart',\App\callback\onWorkStart::class);
$container->singleton('request',\App\callback\onRequest::class);
$container->singleton('storage',\App\Services\Storage\Redis::class);

return $container;