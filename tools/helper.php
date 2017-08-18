<?php
/**
 * Created by PhpStorm.
 * User: dawnki
 * Date: 17-8-16
 * Time: 上午12:05
 */


define('ROOT', __DIR__ . '/..');

if (!function_exists('logger')) {
    /**
     *  打印内容至终端
     * @param $msg
     * @param string $title
     */
    function logger($msg, $title = "Debug")
    {
        echo "-------------------------------\n";
        echo '[' . date('Y-m-d H:i:s', time()) . "] " . $title . ':[' . $msg . "]\n";
        echo "-------------------------------\n";
    }
}

if (!function_exists('writeLog')) {
    /**
     *  记录日志
     * @param $msg
     * @param string $level
     */
    function writeLog($msg, $level = 'info')
    {
        $filename = ROOT . '/storage/logs/' . date('Y_m_d');
        switch (strtolower($level)) {
            case 'info':
                $filename .= '.log';
                break;
            case 'error':
                $filename .= '.error.log';
                break;
            case 'debug':
                $filename .= '.debug.log';
                break;
            default :
                $filename .= '.log';
                break;
        }
        $handle = fopen($filename, 'a');
        flock($handle, LOCK_EX);
        @fwrite($handle, (string)$msg . PHP_EOL);
        flock($handle, LOCK_UN);
    }
}

if (!function_exists('app')) {
    /**
     *  从ioc容器获取对象
     *
     * @param  string $abstract
     * @param  array $parameters
     * @return mixed
     */
    function app($abstract = null, array $parameters = [])
    {
        if (is_null($abstract)) {
            return $GLOBALS['container'];
        }
        return empty($parameters)
            ? $GLOBALS['container']->make($abstract)
            : $GLOBALS['container']->makeWith($abstract, $parameters);
    }
}

if (!function_exists('config')) {
    /**
     *  获取配置文件
     * @param $key
     * @return mixed
     */
    function config($key)
    {
        $filename = ROOT . '/config/' . $key . '.php';
        $arr = require $filename;
        return $arr;
    }
}

if (!function_exists('Hash_Create')) {
    /**
     *   哈希加密
     * @param $password
     * @param null $option
     * @return bool|string
     */
    function Hash_Create($password, $option = null)
    {
        return $option ?
            password_hash($password, PASSWORD_DEFAULT, $option) :
            password_hash($password, PASSWORD_DEFAULT);
    }
}

if (!function_exists('Hash_Check')) {
    /**
     *  验证密码
     * @param $password
     * @param $hash
     * @return bool
     */
    function Hash_Check($password, $hash)
    {
        return password_verify($password, $hash) ? true : false;
    }
}

if (!function_exists('toJson')) {
    /**
     *  将字符串转为json
     * @param $content mixed
     * @return string
     */
    function toJson($content)
    {
        return json_encode($content, JSON_UNESCAPED_UNICODE);
    }
}

if (!function_exists('ret')) {
    function ret($msg, $status = false, $err_code = null)
    {
        return $status ?
            toJson([
                'status' => 1,
                'err' => 'OK!',
                'content' => $msg
            ]) :
            toJson([
                'status' => 0,
                'err' => [
                    'code' => $err_code,
                    'msg' => $msg
                ]
            ]);
    }
}

if (!function_exists('getRoot')) {
    /**
     *  获取项目路径
     * @return string
     */
    function getRoot()
    {
        return ROOT;
    }
}

if (!function_exists('printstr')) {
    /**
     * @param $string
     */
    function printstr($string)
    {
        $strlen = strlen($string);
        for ($j = 0; $j < $strlen; $j++) {
            $num = ord($string{$j});
            if ($num > 31)
                $chr = $string{$j}; else $chr = " ";
            printf("%4d: %08b : 0x%02x : %s \n", $j, $num, $num, $chr);
        }
    }
}

if (!function_exists('ASCLL2INT')) {
    /**
     *  多位Ascll码转整形  获取报文中各种长度专用
     * @param $str
     * @param $start
     * @param $len
     * @return int
     */
    function ASCCLL2INT($str,$start,$len)
    {
        $ascll = substr($str, $start, $len);  //长度的ascll码
        $len = "";
        for ($i = 0; $i < strlen($ascll); $i++) {
            $len .= ord($ascll[$i]);
        }
        return (int)$len;
    }
}