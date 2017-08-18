<?php
/**
 * Created by PhpStorm.
 * User: dawnki
 * Date: 17-8-18
 * Time: 上午10:30
 */

namespace App\Services\ChatRoom\Action;


use App\Services\ChatRoom\ChatManage;
use Swoole\Mysql\Exception;

class Connect extends abstractAction
{

    protected $clientIdentity;

    protected $userId;

    protected $token;

    public function __construct(ChatManage $manage)
    {
        parent::__construct($manage);

        $raw = $this->manage->data;

        $offset = 12;
        $identity_len = ASCCLL2INT($raw, $offset, 2);
        $this->clientIdentity = substr($this->manage->data, $offset + 2, $identity_len);

        $offset = $offset + 2 + $identity_len;
        $userId_len = ASCCLL2INT($raw, $offset, 2);
        $this->userId = substr($this->manage->data, $offset + 2, $userId_len);

        $offset = $offset + 2 + $userId_len;
        $token_len = ASCCLL2INT($raw, $offset, 2);
        $this->token = substr($this->manage->data, $offset + 2, $token_len);
    }

    /**
     *  获取用户名 密码
     */
    public function handle()
    {
        echo $this->checkFlag();
    }

    /**
     *  获取协议名称
     * @return bool|string
     */
    public function getProtocolName()
    {
        return substr($this->manage->data, 4, 4);
    }

    /**
     *  检查连接标志 去除遗嘱信息
     * @throws Exception
     */
    public function checkFlag()
    {
        $raw = $this->manage->data;
        //(194)二进制 => 1100 0010
        if (ASCCLL2INT($raw, 9, 1) != 194) {
            throw new Exception('连接标志出错,不是1100 0010');
        }
    }
}