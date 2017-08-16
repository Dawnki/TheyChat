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
     * Get the available container instance.
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