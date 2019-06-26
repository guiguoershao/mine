### CGI, FastCGI,PHP-FPM之间的关系
* 来源 https://segmentfault.com/a/1190000008627499
* 来源 https://segmentfault.com/a/1190000004006596
* 来源 https://segmentfault.com/a/1190000004638171
## Web Service(Nginx、Apache)、FastCGI、PHP-CGI与PHP-FPM概念、之间关系和处理流程
* CGI：Common Gateway Interface 公共网关接口，web服务器和脚本语言通信的一个标准、
接口、协议【协议】

* FastCGI：CGI协议的升级版【协议】

* PHP-CGI: 实现了CGI接口协议的PHP脚本解析器【程序】

* PHP-FPM: 管理和调度php-cgi进程，进而实现了FastCGI接口协议的程序【程序】

### 名词解释说明

#### Web Service 
* web server (apache/nginx/iis) 只是内容的分发者.
    
#### CGI
* cgi 就是规定要传哪些数据, 以什么样的格式传递给后方处理这个请求的协议
* cgi 是一个协议,跟进程没有关系
```
当webserver收到/index.php这个请求后,会启动对应的cgi程序, 这里就是php的解析器.接下来php解析器会解析php.ini文件,初始化执行环境,然后处理请求,再以cgi规定的格式返回处理后的结果,退出进程. webserver再把结果返回给浏览器
```

#### FastCGI
* FastCGI是用来提高CGI程序性能的
* FastCGI会先启一个master，解析配置文件，初始化执行环境，然后再启动多个worker。当请求过来时，master会传递给一个worker，然后立即可以接受下一个请求。这样就避免了重复的劳动，效率自然是高。而且当worker不够用时，master可以根据配置预先启动几个worker等着；当然空闲worker太多时，也会停掉一些，这样就提高了性能，也节约了资源。这就是FastCGI的对进程的管理。
* CGI程序只能在Web服务器本机执行，而基于FastCGI的管理下，CGI程序可以被部署在远程，通过TCP Socket或者Unix domain Socket来传输数据，这种模式可以理解为FastCGI代理。
 * FastCGI管理器有多种形式。例如：Apache和Lighttpd是通过模块的方式实现FastCGI管理器的，而Nginx则是通过FastCGI代理模式实现的（也就是说需要一个单独的FastCGI管理器进程，该进程通过侦听TCP Socket或者Unix domain Socket在Nginx和CGI程序之间起到桥梁作用）。
   



#### PHP-FPM
* 是一个实现了FastCGI的程序，被PHP官方收了。
* 大家都知道，PHP的解释器是php-cgi。php-cgi只是个CGI程序，他自己本身只能解析请求，返回结果，不会进程管理（皇上，臣妾真的做不到啊！）所以就出现了一些能够调度php-cgi进程的程序，比如说由lighthttpd分离出来的spawn-fcgi。好了PHP-FPM也是这么个东东，在长时间的发展后，逐渐得到了大家的认可（要知道，前几年大家可是抱怨PHP-FPM稳定性太差的），也越来越流行。
  
* 好了，PHP-FPM就是针对于PHP的，FastCGI的一种实现，他负责管理一个进程池，来处理来自Web服务器的请求。目前，PHP-fpm是内置于PHP的。
* 但是PHP-fpm仅仅是个“PHP Fastcgi 进程管理器”, 它仍会调用PHP解释器本身来处理请求，PHP解释器(在Windows下)就是php-cgi.exe.



#### CGI与FastCGI关系
* CGI与FastCGI都是一种通讯协议，是WebSever（Apache/Nginx/IIS）与其它程序（此程序通常叫做CGI程序，如PHP脚本解析器）之间通讯的桥梁。
* FastCGI是CGI的改良进化版，FastCGI相比CGI更安全、性能更好,所以现在都是使用FastCGI协议进行通讯。
* FastCGI兼容CGI。
#### PHP-CGI与PHP-FPM
* PHP-CGI其实就是PHP脚本解析器，他是CGI协议的实现
* PHP-FPM就是FastCGI协议的实现
* PHP-CGI和PHP-FPM都是程序，