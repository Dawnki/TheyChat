<?php
/**
 * Created by PhpStorm.
 * User: dawnki
 * Date: 17-8-17
 * Time: 上午11:31
 */

namespace App\Services\Auth;

class Execute
{
    protected $manage;

    protected $redis_config;

    protected $storage;

    public function __construct(AuthManage $manage)
    {
        $this->manage = $manage;
        $this->redis_config = config('redis');
        $this->storage = app('storage');
    }

    public function login()
    {
        $request = $this->manage->jsonData;
        if (!isset($request['userId']) || !isset($request['password'])) {
            $this->manage->Response(ret('账号密码不对!', false, 500), 500);
            return;
        }
        $userId = $request['userId'];
        $password = $request['password'];
        $prefix = $this->redis_config['PREFIX']['login'];
        $hash = $this->storage->get($prefix . $userId);
        if (Hash_Check($password, $hash)) {
            $prefix = $this->redis_config['PREFIX']['token'];
            $token = Hash_Create($password . time());
            $this->storage->set($prefix . $userId, $token);
            $this->manage->Response(
                ret(['Token' => $token], true), 200
            );
            return;
        } else {
            $this->manage->Response(ret('账号或密码不对!', false, 403), 403);
            return;
        }
    }

    public function register()
    {
        $request = $this->manage->jsonData;
        if (!isset($request['userId']) || !isset($request['password'])) {
            $this->manage->Response(ret('账号或密码缺失!', false, 500), 500);
            return;
        }
        $userId = $request['userId'];
        $password = $request['password'];
        $prefix = $this->redis_config['PREFIX']['login'];
        $isExist = $this->storage->exists($prefix . $userId);
        if ($isExist) {
            $this->manage->Response(ret('账号已经存在!', false, 500), 500);
            return;
        } else {
            $this->storage->set($prefix . $userId, Hash_Create($password));
            $this->manage->Response(ret('注册成功!', true, 200), true, 200);
            return;
        }
    }


    public function logout()
    {

    }

}