<?php
/**
 * Created by PhpStorm.
 * User: dawnki
 * Date: 17-8-16
 * Time: 下午4:01
 */

namespace App\callback;

use App\Services\Auth\AuthManage;


/**
 *  HTTP服务回调函数
 * Class onRequest
 * @package App\callback
 */
class onRequest
{
    protected $auth;

    public function __construct(AuthManage $manage)
    {
        $this->auth = $manage;
    }

    /**
     * @param $request \swoole_http_request
     * @param $response \swoole_http_response
     */
    public function run($request, $response)
    {
        //logger('Receive a Request!');
        $this->auth->bootstrap($request, $response);
    }
}