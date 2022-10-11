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
namespace App\Controller;

use App\Utils\Helper;

class IndexController extends AbstractController
{
    //protected Helper $helper;

    /**
     * @var Helper
     */
    protected $helper;

    public function __construct(Helper $helper)
    {
        $this->helper = $helper;
    }

    public function index()
    {
        //$helper = new Helper();
        //return $this->helper->getTime();

        $user = $this->request->input('user', 'Hyperf');
        $method = $this->request->getMethod();

        return [
            'method' => $method,
            'message' => "Hello {$user}.",
            'time' => $this->helper->getTime()
        ];
    }

    public function test() {
        $h = make(Helper::class);
        return $h->getTime();
    }

    public function hello() {
        return $this->helper->getTime();
    }
}
