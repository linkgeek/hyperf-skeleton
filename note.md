
## 安装依赖
composer require hyperf/session
composer require hyperf/redis


php bin/hyperf.php describe:routes


php73 -d swoole.use_shortname=off ./bin/hyperf.php start

## 定义一个监听器
php bin/hyperf.php gen:listener UserRegisteredListener

## 测试 TCP
telnet 127.0.0.1 9503

在窗口输入
{"handler":"Test","method":"rpc","params":{"name":"111","age":18}}
{"handler":"Test","method":"task","params":{"name":"22","age":38}}
{"handler":"Test","method":"task2","params":{"name":"22","age":38}}