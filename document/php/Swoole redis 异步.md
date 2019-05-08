### Swoole Redis\Server异步客户端介绍
* Swoole-1.8.14版本增加一个兼容Redis服务器端协议的Server框架，可基于此框架实现Redis协议的服务器程序。Swoole\Redis\Server继承自Swoole\Server，可调用父类提供的所有方法。
* Redis\Server不需要设置onReceive回调。实例程序：https://github.com/swoole/swoole-src/blob/master/examples/redis/server.php

#### 可用的客户端
* 任意编程语言的redis客户端，包括PHP的redis扩展和phpredis库
* Swoole扩展提供的异步Redis客户端
* Redis提供的命令行工具，包括redis-cli、redis-benchmark
* 注意：Swoole-1.8.0版本增加了对异步Redis客户端的支持，基于redis官方提供的hiredis库实现。Swoole提供了__call魔术方法，来映射绝大部分Redis指令。

#### 编译安装hiredis
* 使用Redis客户端，需要安装hiredis库。下载hiredis源码后，执行
```
make -j
sudo make install
sudo ldconfig
```
* hiredis下载地址：https://github.com/redis/hiredis/releases

#### 重新编译swoole
* 编译swoole是，在configure指令中加入--enable-async-redis
```
./configure --enable-async-redis
make clean
make -j
sudo make install
```
* 在重新编译安装swoole后,使用php --ri swoole看到async redis client或者redis_client代表异步redis客户端安装成功

