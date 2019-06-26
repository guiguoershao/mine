apache是通过mod_php来解析php  nginx是通过php-fpm(fast-cgi)来解析php
1. PHP 解释器是否嵌入 Web 服务器进程内部执行
mod_php 通过嵌入 PHP 解释器到 Apache 进程中，只能与 Apache 配合使用，而 cgi 和 fast-cgi 以独立的进程的形式出现，只要对应的Web服务器实现 cgi 或者 fast-cgi 协议，就能够处理 PHP 请求。
mod_php 这种嵌入的方式最大的弊端就是内存占用大，不论是否用到 PHP 解释器都会将其加载到内存中，典型的就是处理CSS、JS之类的静态文件是完全没有必要加载解释器。
2. 单个进程处理的请求数量
mod_php 和 fast-cgi 的模式在每个进程的生命周期内能够处理多个请求(fast-cgi可以根据需要来调整进程的多少)，而 cgi 的模式处理一个请求就马上销毁进程，在高并发的场景下 cgi 的性能非常糟糕。 
每一个Web请求PHP都必须重新解析php.ini、重新载入全部dll扩展并重初始化全部数据结构。使用FastCGI，所有这些都只在进程启动时发生一次
综上，如果对性能有极高的要求，可以将静态请求和动态请求分开，这时 Nginx + php-fpm 是比较好的选择。
PS: cgi、fastcgi 通常指 Web 服务器与解释器通信的协议规范，而 php-fpm 是 fastcgi 协议的一个实现。