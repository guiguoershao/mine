### MYSQL 5.7 基础配置命令
##### 授权远程ip连接
```
use mysql;
// 查看数据库用户以及已经开放的IP
select user,host from user;
// 授权 所有ip % 
grant all privileges on *.* to '用户名'@'IP' identified by '密码';
// 刷新权限即可
flush privileges;
```
* 打开mysql配置文件 注释  bind-address          = 127.0.0.1
* 重启服务器即可
##### 创建mysql账号
* username - 你将创建的用户名
* host - 指定该用户在哪个主机上可以登陆，此处的"localhost"，是指该用户只能在本地登录，不能在另外一台机器上远程登录，如果想远程登录的话，将"localhost"改为"%"，表示在任何一台电脑上都可以登录;也可以指定某台机器可以远程登录;
* password - 该用户的登陆密码,密码可以为空,如果为空则该用户可以不需要密码登陆服务器。
```
CREATE USER 'username'@'host' IDENTIFIED BY 'password';
```

##### 授权
```
GRANT privileges ON databasename.tablename TO 'username'@'host'
```
* privileges - 用户的操作权限,如SELECT , INSERT , UPDATE 等,如果要授予所的权限则使用ALL.;
* databasename - 数据库名,
* tablename-表名,如果要授予该用户对所有数据库和表的相应操作权限则可用*表示, 如*.*.

##### 创建用户同时授权
```
GRANT privileges ON databasename.tablename TO 'username'@'host' IDENTIFIED BY 'password';
```

##### 设置与更改用户密码
```
SET PASSWORD FOR 'username'@'host' = PASSWORD('newpassword');
```

##### 撤销用户权限
```
REVOKE privilege ON databasename.tablename FROM 'username'@'host';
例子: REVOKE SELECT ON mq.* FROM 'dog2'@'localhost';
```
* privilege, databasename, tablename - 同授权部分.
* PS: 假如你在给用户'dog'@'localhost''授权的时候是这样的(或类似的):GRANT SELECT ON test.user TO 'dog'@'localhost', 则在使用REVOKE SELECT ON *.* FROM 'dog'@'localhost';命令并不能撤销该用户对test数据库中user表的SELECT 操作.相反,如果授权使用的是GRANT SELECT ON *.* TO 'dog'@'localhost';则REVOKE SELECT ON test.user FROM 'dog'@'localhost';命令也不能撤销该用户对test数据库中user表的Select 权限.

##### 删除用户
```
DROP USER 'username'@'host';
```

##### 查看用户的授权
```
show grants for 'username'@'host';
```
* flush privileges;  所有操作执行后必须执行此命令