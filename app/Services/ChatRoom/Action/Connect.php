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

    protected $storage;

    public function __construct(ChatManage $manage)
    {
        parent::__construct($manage);

        $raw = $this->manage->data;

        $offset = 12;
        $identity_len = ASCCLL2INT($raw, $offset, 2);
        $this->clientIdentity = substr($this->manage->data, $offset + 2, $identity_len);

        $offset += 2 + $identity_len;
        $userId_len = ASCCLL2INT($raw, $offset, 2);
        $this->userId = substr($this->manage->data, $offset + 2, $userId_len);

        $offset += 2 + $userId_len;
        $token_len = ASCCLL2INT($raw, $offset, 2);
        $this->token = substr($this->manage->data, $offset + 2, $token_len);

        $this->storage = app('storage');
    }

    /**
     *  处理连接流程
     */
    public function handle()
    {
        $this->log();
        $this->checkProtocol();
        $this->checkFlag();
        $this->checkToken();
        //@todo 建立userId-fd 以及 fd-userId  用于检验权限!!
        $this->store();  //验证权限成功后 建立fd与用户名的关联
        $this->Connask();
    }

    private function log()
    {
        printstr($this->manage->data);
    }

    /**
     *  检查协议
     * @throws \Exception
     */
    private function checkProtocol()
    {
        $protocol = substr($this->manage->data, 4, 4);
        if (strtolower($protocol) != 'mqtt') {
            throw  new \Exception('协议出错,不是mqtt协议');
        }
    }

    /**
     *  检查连接标志 去除遗嘱信息
     * @throws Exception
     */
    private function checkFlag()
    {
        $raw = $this->manage->data;
        //(194)二进制 => 1100 0010
        if (ASCCLL2INT($raw, 9, 1) != 194) {
            throw new Exception('连接标志出错,不是1100 0010');
        }
    }

    /**
     *  检查token
     * @throws Exception
     */
    private function checkToken()
    {
        $prefix = config('redis')['PREFIX']['token'];
        $token = $this->storage->get($prefix . $this->userId);
        if ($this->token != $token) {
            throw new Exception('Token验证失败!');
        }
    }

    /**
     *  存储用户与fd的关系
     */
    private function store()
    {
        $prefix = config('redis')['PREFIX']['connection'];
        $this->storage->set($prefix . $this->userId, $this->manage->fd);
    }

    /**
     *  返回连接确认
     */
    private function Connask()
    {
        $response = chr(32) . chr(2) . chr(0) . chr(0);
        $this->manage->server->send($this->manage->fd, $response);
    }
}