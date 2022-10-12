<?php

use App\Exception\BusinessException;
use Hyperf\Logger\LoggerFactory;
use Hyperf\Utils\ApplicationContext;

if (!function_exists('dd')) {
    function dd() {
        $args = func_get_args();
        foreach ($args as $arg) {
            echo "<pre>";
            if (is_bool($arg)) {
                var_dump($arg);
            } else {
                print_r($arg);
            }
        }
        exit;
    }
}

if (!function_exists('businessException')) {
    /**
     * 抛出异常处理
     * @param $msg
     * @param int $code
     * @param array $params
     * @throws BusinessException
     */
    function businessException($msg, $code = 1000, $params = [])
    {
        throw new BusinessException($msg, $params, $code);
    }
}

if (!function_exists('trace')) {
    /**
     * 记录日志信息
     * @param mixed $log log信息 支持字符串和数组
     * @param string $level 日志级别
     */
    function trace($log = '[think]', string $level = 'info')
    {
        $logger = ApplicationContext::getContainer()->get(LoggerFactory::class)->get('app');
        if (!is_string($log)) {
            $log = var_export($log, true);
        }

        $logger->log($level, $log);
    }
}