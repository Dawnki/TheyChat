<?php
/**
 * Created by PhpStorm.
 * User: dawnki
 * Date: 17-8-18
 * Time: 上午10:33
 */

namespace App\Services\ChatRoom\Action;


use App\Services\ChatRoom\ChatManage;

class Publish extends abstractAction
{

    protected $topic;

    protected $content;

    protected $storage;

    public function __construct(ChatManage $manage)
    {
        parent::__construct($manage);

        $raw = $this->manage->data;

        $offset = 2;
        $topic_len = ASCCLL2INT($raw, $offset, 2);
        $this->topic = substr($raw, $offset + 2, $topic_len);

        $offset += 2 + $topic_len;
        $content_len = ASCCLL2INT($raw, 1, 1) - $topic_len - 2;     //内容的长度=剩余长度-主题长度-主题长度字节(2字节)
        $this->content = substr($raw, $offset, $content_len);

        $this->storage = app('storage');
    }

    /**
     *  处理广播
     */
    public function handle()
    {
        $this->broadcast();
    }

    /**
     *  topic格式  A-B-C-D   A为发送者,后者都为接受者
     *  广播用户的发送内容
     */
    private function broadcast()
    {
        $userIds = explode('-', $this->topic);
        $fds = [];
        $prefix = config('redis')['PREFIX']['connection'];
        for ($i = 1; $i < count($userIds); $i++) {
            $fd = $this->storage->get($prefix . $userIds[$i]);
            if (!empty($fd)) {
                $fds[] = $fd;
            }
        }
        if (!empty($fds)) {
            $sendBag = [
                'fds' => $fds,
                'content' => $this->content
            ];
            $this->manage->server->task($sendBag);  //非阻塞广播
        }
    }
}