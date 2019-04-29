### Mysql5.7搭建主从数据库

* 转载 https://blog.csdn.net/innocent_jia/article/details/89288236
#### 准备工作
* 主服务器IP 172.16.20.73 Mysql账号密码: master, master
* 从服务器IP 172.16.20.75 Mysql账号密码: slave, slave
##### 创建账号并授权
```
CREATE USER 'master'@'%' IDENTIFIED BY 'master';
GRANT ALL ON *.* TO 'master'@'%'

CREATE USER 'slave'@'%' IDENTIFIED BY 'slave';
GRANT ALL ON *.* TO 'slave'@'%'

flush privileges; 
```

#### 配置主服务器
* 修改 /etc/mysql/mysql.conf.d/mysqld.cnf 文件，在对应位置添加如下两行
```
[mysqld]
# 将mysql二进制日志取名为mysql-bin
log-bin         = mysql-bin
# 服务器集群的唯一标志 id
server-id       = 1 
```
* 授权给从服务器，使之能够连接主服务器（相当于给从服务器一把钥匙，使之能够访问主服务器上的日志文件）
```
GRANT REPLICATION SLAVE,RELOAD,SUPER ON *.* TO 'slave'@'172.16.20.75' IDENTIFIED BY 'slave@slave';
```

* 查询主服务器状态（如果没有进行第一步的那两行配置，这里执行后会显示 Empty Set），记录下 FILE 和 Position 的值，接下来会有用
```
show master status\G;
```

#### 配置从服务器
* 修改 /etc/mysql/mysql.conf.d/mysqld.cnf 文件，在对应位置添加如下一行
```
[mysqld]
# 服务器集群的唯一标志 id
server-id       = 2
```
* 配置同步语句
```
CHANGE MASTER TO MASTER_HOST='172.16.20.73', MASTER_PORT=3306, MASTER_USER='master', MASTER_PASSWORD='master', MASTER_LOG_FILE='mysql-bin.000006', MASTER_LOG_POS=154;
```

* 启动|关闭 slave进程 
```
start slave；
stop slave;
```
* 查看状态
show slave status\G;

```
  Slave_IO_Running: Yes
  Slave_SQL_Running: Yes
  两个都为Yes才算成功
```