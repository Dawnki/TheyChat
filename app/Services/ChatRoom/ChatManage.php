<?php
/**
 * Created by PhpStorm.
 * User: dawnki
 * Date: 17-8-18
 * Time: 上午1:23
 */

namespace App\Services\ChatRoom;

use Swoole\Mysql\Exception;


class ChatManage
{
    /**
     * @var \swoole_server
     */
    public $server;

    /**
     * @var integer 文件描述符
     */
    public $fd;

    /**
     *  接受的数据
     */
    public $data;

    /**
     * @var array 固定头部
     */
    public $fix_header;

    /**
     *  解析报文的控制类型,并且根据报文的类型分发到不同的动作类中
     * @param $server \swoole_server
     * @param $fd
     * @param $reactor_id
     * @param $data
     */
    public function bootstrap($server, $fd, $reactor_id, $data)
    {
        $this->server = $server;
        $this->fd = $fd;
        $this->data = $data;
        try {
            $this->parseType();
            $this->dispatch();
            $server->send($fd,'成功');
        } catch (\Exception $exception) {
            logger($exception->getMessage(), 'Exception');
            $server->send($fd,'错误:'.$exception->getMessage());
            //@todo 可补充断连操作
        }
    }

    /**
     *  解析mqtt控制类型
     */
    private function parseType()
    {
        $data_len_byte = 1;
        $this->fix_header['data_len'] = $this->getMessageLength($this->data, $data_len_byte);
        $byte = ord($this->data[0]);
        $this->fix_header['type'] = ($byte & 0xF0) >> 4;
    }

    /**
     *  根据不同控制类型 将数据分发给对应业务
     */
    private function dispatch()
    {
        $map = require __DIR__ . "/map.php";
        if (isset($map[$this->fix_header['type']])) {
            $className = '\App\Services\ChatRoom\Action\\' . $map[$this->fix_header['type']];
            call_user_func_array([new $className($this), 'handle'], []);
        } else {
            throw new Exception('报文控制类型不正确!');
        }
    }

    /**
     *  获取报文长度
     * @param $msg
     * @param $i
     * @return int
     */
    public function getMessageLength($msg, &$i)
    {
        $multiplier = 1;
        $value = 0;
        do {
            $digit = ord($msg{$i});
            $value += ($digit & 127) * $multiplier;
            $multiplier *= 128;
            $i++;
        } while (($digit & 128) != 0);
        return $value;
    }

}