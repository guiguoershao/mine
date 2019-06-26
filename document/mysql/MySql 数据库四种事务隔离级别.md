### mysql 数据库四种事务隔离级别
##### 查询mysql中食物隔离级别
```
SELECT @@tx_isolation;
```
##### read uncommitted (RU) 读未提交
* 一个事务中.可以读取到其他事务未提交的变更

##### read committed (RC) 读已提交
* 一个事务中.可以读取到其他事务已经提交的变更

#### repeatable read (RR) 可重复读
* 一个事务中,直到事务结束前,都可以反复读取到事务刚开始看到的数据,不会发生变化.
* mysql的默认隔离级别是RR
* 一个事务中RR隔离级别读取到一张表的数据都是一样额
```
事务A	                    事务B
begin;
select * from a	    insert into a(...)
select * from a	
```
RR 隔离级别下: 事务A 第二次select查询的结果是一致的,看不到事务B中插入的数据
RC隔离级别下: 事务A第二次select查询是可以看到事务B中插入的数据

##### serializable (串行读)
* 即便每次读都需要获得表级共享锁,每次写都加表级排它锁,两个会话间会相互阻塞.


```
事务隔离级别                    脏读     不可重复读    幻读
读未提交（read-uncommitted）    是        是            是
不可重复读（read-committed）    否        是            是
可重复读（repeatable-read）     否        否            是
串行化（serializable）          否        否            否
```