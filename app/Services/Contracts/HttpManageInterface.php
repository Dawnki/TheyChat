<?php
/**
 * Created by PhpStorm.
 * User: dawnki
 * Date: 17-8-17
 * Time: 上午9:59
 */

namespace App\Services\Contracts;


interface HttpManageInterface
{
    /**
     * @param $request \swoole_http_request
     * @param $response \swoole_http_response
     * @return mixed
     */
    public function bootstrap($request,$response);
}