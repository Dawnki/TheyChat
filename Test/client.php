<?php
/**
 * Created by PhpStorm.
 * User: dawnki
 * Date: 17-8-15
 * Time: 下午3:04
 */

function hex2asc($str)
{
    $str = join('', explode('\x', $str));
    $len = strlen($str);
    $data = '';
    for ($i = 0; $i < $len; $i += 2) $data .= chr(hexdec(substr($str, $i, 2)));
    return $data;
}

function asc2hex($str)
{
    return '\x' . substr(chunk_split(bin2hex($str), 2, '\x'), 0, -2);
}

$source = '103e00044d51545404ce003c0014436f636f614d5154542d486f7273652d3133383100052f77696c6c00066469656f7574000561646d696e00067075626c6963';
$source = hex2asc($source);

$client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);

$client->on('connect', function ($cli) use ($source) {
    $cli->send($source);
});

$client->on('receive', function ($cli, $data) {
    echo asc2hex($data);
});

$client->on('close', function ($cli) {
    echo 'connection close' . "\n";
});

$client->on('error', function ($cli) {

});

$client->connect('127.0.0.1', 9999, 0.5);