<?php

namespace App\Listener;

use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Framework\Event\OnReceive;


class TcpListener implements ListenerInterface
{

    public function listen(): array
    {
        return [
            OnReceive::class,
        ];
    }

    public function process(object $event)
    {
        var_dump($event->data);
    }
}