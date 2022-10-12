<?php

namespace App\Listener;

use App\Exception\BusinessException;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Framework\Event\OnReceive;
use Hyperf\Logger\LoggerFactory;
use Psr\Log\LoggerInterface;
use Throwable;

/**
 * Tcp监听器
 */
class TcpListener implements ListenerInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var string|null handler控制器
     */
    private $handler = null;

    /**
     * @var string|null method方法
     */
    private $method = null;

    /**
     * @var array|null 请求参数
     */
    private $params = null;

    /**
     * @var array 返回结果
     */
    private $result = [];

    public function __construct(LoggerFactory $loggerFactory)
    {
        $this->logger = $loggerFactory->get('app');
    }

    /**
     * 监听事件
     * @return string[]
     */
    public function listen(): array
    {
        // 返回一个该监听器要监听的事件数组，可以同时监听多个事件
        return [
            OnReceive::class,
        ];
    }

    /**
     * 业务逻辑
     * @param object $event
     * @return void
     */
    public function process(object $event)
    {
        try {
            $this->initResult();
            $this->parseParams($event->data);
            $this->run();
        } catch (BusinessException $e) {
            $this->result['code'] = $e->getCode();
            $this->result['msg'] = $e->getMessage();
            $this->result['data'] = $e->getParams();
            $this->writeLog($e);
        } catch (Throwable $e) {
            $this->result['code'] = 500;
            $this->result['msg'] = $e->getMessage();
            $this->writeLog($e);
        }

        // 返回客户端结果
        $fd = $event->fd;
        if ($event->server->exist($fd)) {
            $event->server->send($fd, json_encode($this->result));
        }
    }

    /**
     * 重置返回结果
     * @return void
     */
    private function initResult()
    {
        $this->result = [
            'code' => 0,
            'msg' => '',
            'data' => []
        ];
    }

    /**
     * 解析参数
     * @param $eventData
     * @throws BusinessException
     */
    private function parseParams($eventData)
    {
        $data = json_decode($eventData, true);
        if (empty($data) || !is_array($data)) {
            businessException('参数错误');
        }

        $this->handler = $data['handler'];
        $this->method = $data['method'];
        $this->params = $data['params'];
    }

    /**
     * 执行逻辑
     * @return void
     */
    private function run()
    {
        $handlerClass = '\\App\\Controller\\' . $this->handler . 'Controller';
        if (!class_exists($handlerClass)) {
            businessException('handler not found.', 404);
        }

        $handlerInstance = make($handlerClass, []);
        if (!method_exists($handlerInstance, $this->method)) {
            businessException('method not found.', 404);
        }

        $this->result['data'] = $handlerInstance->{$this->method} ($this->params);

        $this->logger->info('----------------');
    }

    /**
     * 记录错误日志
     * @param $e
     * @return void
     */
    private function writeLog($e)
    {
        trace([
            'Exception' => [
                'File' => $e->getFile(),
                'Line' => $e->getLine(),
                'Message' => $e->getMessage(),
                'Error Code' => $e->getCode(),
            ]
        ],
            'error'
        );
    }
}