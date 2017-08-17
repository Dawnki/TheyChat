<?php
/**
 * Created by PhpStorm.
 * User: dawnki
 * Date: 17-8-16
 * Time: 下午4:01
 */

namespace App\callback;

/**
 *  HTTP服务回调函数
 * Class onRequest
 * @package App\callback
 */
class onRequest
{
    /**
     * @param $request \swoole_http_request
     * @param $response \swoole_http_response
     */
    public function run($request,$response)
    {
        $response->end('hello async http!');
    }
}