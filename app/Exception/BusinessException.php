<?php

namespace App\Exception;


use Hyperf\Server\Exception\ServerException;
use Throwable;

class BusinessException extends ServerException
{
    protected $params;

    public function __construct(string $message = null, array $params = [], int $code = 0, Throwable $previous = null)
    {
        if (is_null($message)) {
            $message = 'unknown';
        }

        $this->params = $params;
        parent::__construct($message, $code, $previous);
    }

    public function getParams()
    {
        return $this->params;
    }
}