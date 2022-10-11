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
     * @Inject
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    //监听链接事件
    public function onConnect($server, int $fd)
    {
        echo "$fd client : connect\n";
    }

    //监听接收事件
    public function onReceive($server, int $fd, int $reactorId, string $data): void
    {
        //$server->send($fd, 'recv:' . $data);
        $this->eventDispatcher->dispatch(new OnReceive($server, $fd, $reactorId, $data));
    }

    //监听关闭事件
    public function onClose($server, int $fd)
    {
        echo "$fd client close.\n";
    }
}