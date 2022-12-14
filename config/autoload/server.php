<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
use Hyperf\Server\Event;
use Hyperf\Server\Server;
use Swoole\Constant;

return [
    'mode' => SWOOLE_PROCESS,
    'servers' => [
        [
            'name' => 'http',
            'type' => Server::SERVER_HTTP,
            'host' => '0.0.0.0',
            'port' => 9502,
            'sock_type' => SWOOLE_SOCK_TCP,
            'callbacks' => [
                Event::ON_REQUEST => [Hyperf\HttpServer\Server::class, 'onRequest'],
            ],
        ],
        // tcp服务配置
        [
            'name'      => 'tcp',
            'type'      => Server::SERVER_BASE,
            'host'      => '0.0.0.0',
            'port'      => 9503,
            'sock_type' => SWOOLE_SOCK_TCP,
            'callbacks' => [
                Event::ON_CONNECT => [App\Server\TcpServer::class, 'onConnect'],
                Event::ON_RECEIVE => [App\Server\TcpServer::class, 'onReceive'],
                Event::ON_CLOSE => [App\Server\TcpServer::class, 'onClose'],
            ],
            'settings' => [
                // 按需配置
            ],
        ],
    ],
    'settings' => [
        Constant::OPTION_ENABLE_COROUTINE => true, //enable_coroutine
        Constant::OPTION_WORKER_NUM => swoole_cpu_num(), //worker_num
        Constant::OPTION_PID_FILE => BASE_PATH . '/runtime/hyperf.pid', //pid_file
        Constant::OPTION_OPEN_TCP_NODELAY => true, //open_tcp_nodelay
        Constant::OPTION_MAX_COROUTINE => 100000, //max_coroutine
        Constant::OPTION_OPEN_HTTP2_PROTOCOL => true, //open_http2_protocol
        Constant::OPTION_MAX_REQUEST => 100000, //max_request
        Constant::OPTION_SOCKET_BUFFER_SIZE => 2 * 1024 * 1024, //socket_buffer_size
        Constant::OPTION_BUFFER_OUTPUT_SIZE => 2 * 1024 * 1024, //buffer_output_size
        // user settings
        Constant::OPTION_TASK_WORKER_NUM => 2, //task_worker_num
        Constant::OPTION_LOG_FILE => BASE_PATH . '/runtime/logs/' . APP_NAME . '.log',
        Constant::OPTION_LOG_LEVEL => SWOOLE_LOG_WARNING,
    ],
    'callbacks' => [
        Event::ON_WORKER_START => [Hyperf\Framework\Bootstrap\WorkerStartCallback::class, 'onWorkerStart'],
        Event::ON_PIPE_MESSAGE => [Hyperf\Framework\Bootstrap\PipeMessageCallback::class, 'onPipeMessage'],
        Event::ON_WORKER_EXIT => [Hyperf\Framework\Bootstrap\WorkerExitCallback::class, 'onWorkerExit'],
        // Task callbacks
        Event::ON_TASK => [Hyperf\Framework\Bootstrap\TaskCallback::class, 'onTask'],
        Event::ON_FINISH => [Hyperf\Framework\Bootstrap\FinishCallback::class, 'onFinish'],
    ],
];
