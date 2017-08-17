<?php
/**
 * Created by PhpStorm.
 * User: dawnki
 * Date: 17-8-17
 * Time: 上午9:56
 */

namespace App\Services\Auth;


use App\Services\Contracts\HttpManageInterface;

class AuthManage implements HttpManageInterface
{
    /**
     * @var \swoole_http_request
     */
    private $request;

    /**
     * @var \swoole_http_response
     */
    private $response;

    /**
     * @var array
     */
    public $jsonData;


    /**
     *  接受请求,解析请求,分发给业务逻辑,响应返回
     * @param \swoole_http_request $request
     * @param \swoole_http_response $response
     * @return mixed|void
     */
    public function bootstrap($request, $response)
    {
        try {
            $this->setting($request, $response);
            $this->parseRequest();
            $this->dispatch();
        } catch (\Exception $exception) {
            $this->Response(
                ret(
                    $exception->getMessage(), false, $exception->getCode()
                ),
                $exception->getCode()
            );
        }
    }

    /**
     *  初始化设置
     * @param $request \swoole_http_request
     * @param $response \swoole_http_response
     */
    private function setting($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     *  从请求中解析json数据
     */
    private function parseRequest()
    {
        $this->jsonData = json_decode($this->request->rawContent(), true);
    }

    /**
     *  解析路由并分发请求内容
     * @throws \Exception
     */
    private function dispatch()
    {
        $url = $this->request->server['request_uri'];
        //只解析一级路径
        preg_match('/\/[a-zA-Z]*/', $url, $result);
        $map = require __DIR__ . "/route.php";
        if (empty($map[$result[0]])) {
            throw  new \Exception('路由错误!', 404);
        }
        $method = $map[$result[0]];
        call_user_func_array([new Execute($this), $method], []);
    }

    /**
     * 响应内容
     * @param $message
     * @param int $http_status_code
     */
    public function Response($message, $http_status_code = 200)
    {
        $this->response->header('Content-Type', 'application/json');
        if (isset($http_status_code)) {
            $this->response->status($http_status_code);
        }
        $this->response->end($message);
    }
}