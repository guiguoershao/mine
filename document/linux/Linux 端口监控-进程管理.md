## 端口监控
* 在ip章节中,我们知道了,开启一个tcp/udp服务,都得占用一个端口,所有我们可以通过查看端口的方式去判断服务是否开启成功.

### netstat命令
##### 使用netstat命令可查看端口占用情况  netstat命令各个参数说明如下:
* -t : 指明显示TCP端口
* -u : 指明显示UDP端口
* -l : 仅显示监听套接字(所谓套接字就是使应用程序能够读写与收发通讯协议(protocol)与资料的程序)
* -p : 显示进程标识符和程序名称，每一个套接字/端口都属于一个程序。
* -n : 不进行DNS轮询，显示IP(可以加速操作)

```
netstat -ntulp |grep 80
```


### lsof命令
* lsof命令需要自行安装

```
sudo yum install lsof
```
* 使用方法如下:

```
lsof  -i tcp #列出所有tcp网络连接
lsof  -i udp #列出所有udp网络连接信息
lsof -i :8080 #列出使用8080端口信息
```


## 进程管理

* 我们可以使用ps 查看当前进程(相当于windows的任务管理器)

```
ps -ef |grep php
```
* 输出:

```
root       8351   8346  0 09:07 ?        00:00:00 /usr/bin/php /www/wwwroot/es3_demo/test.php
root      10618   8970  0 14:26 pts/0    00:00:00 grep --color=auto php
```
* 用于筛选出当前运行中,包含php关键字的进程信息 通过kill -9 PID可杀死某一个进程:

```
kill -9 10618

```
* 使用killall 可杀死指定名字的进程:

```
killall -9 php
```
* 杀死所有php进程

* kill 和killall其实是给进程发送一个进程信号的命令,-9是SIGKILL 信号,终止进程,可通过kill ,killall命令发送其他信号