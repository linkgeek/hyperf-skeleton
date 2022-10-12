<?php

declare(strict_types=1);

namespace App\Server;

use Hyperf\Contract\OnReceiveInterface;
use Hyperf\Di\Annotation\Inject;
use Psr\EventDispatcher\EventDispatcherInterface;
use Hyperf\Framework\Event\OnReceive;

class TcpServer implements OnReceiveInterface
{
    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    //监听链接事件
    public function onConnect($server, int $fd)
    {
        echo "$fd client : connect\n";
    }

    //监听接收事件
    public function onReceive($server, int $fd, int $reactorId, string $data): void
    {
        //$server->send($fd, 'recv:' . $data);
        echo 'onReceive: ' . $data . PHP_EOL;

        //触发事件
        $this->eventDispatcher->dispatch(new OnReceive($server, $fd, $reactorId, $data));
    }

    //监听关闭事件
    public function onClose($server, int $fd)
    {
        echo "$fd client close.\n";
    }
}