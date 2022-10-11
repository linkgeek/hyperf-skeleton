
## 安装依赖
composer require hyperf/session
composer require hyperf/redis


php bin/hyperf.php describe:routes


php73 -d swoole.use_shortname=off ./bin/hyperf.php start

## 测试 TCP
telnet 127.0.0.1 9503

在窗口输入