<?php
/**
 * Created by PhpStorm.
 * User: dawnki
 * Date: 17-8-18
 * Time: 上午11:06
 */

namespace App\Services\ChatRoom\Action;


use App\Services\ChatRoom\ChatManage;

abstract class abstractAction
{
    /**
     * @var ChatManage
     */
    protected $manage;

    public function __construct(ChatManage $manage)
    {
        $this->manage = $manage;
    }

    abstract public function handle();
}