<?php

declare(strict_types=1);

namespace App\Controller;

use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Annotation\AutoController;


/**
 * @AutoController()
 */
class TestController extends AbstractController
{
    // Hyperf 会自动为此方法生成一个 /route/index 的路由，允许通过 GET 或 POST 方式请求
    public function index(RequestInterface $request)
    {
        // 从请求中获得 id 参数
        $id = $request->input('id', 1);
        return (string)$id;
    }

    public function get(RequestInterface $request)
    {
        $id = $request->input('id', 1);
        return 'get method' . $id;
    }

    public function test()
    {

    }

    public function hello()
    {

    }

    public function rpc($params)
    {
        $params['from'] = 'rpc';
        return json_encode($params);
    }

    public function task($params)
    {
        $params['from'] = 'task';
        return $params;
    }
}
