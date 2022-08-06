#### 什么是redis
* key-value 数据库
* 性能高
* 原子性
* 丰富的数据类型（list set zet hash）
* 丰富的特性
* 持久化到磁盘中


#### Redis 有哪些适合的场景
* 会话缓存：必memcached更加持久
* 全页缓存：
* 队列：list set，有很多的开源项目
* 排行榜/计数器：redis在内存中对数字的递增和递减有很好的实现（集合和有序集合），
* 发布/订阅

#### 协程进程线程的区别

##### 进程
* 进程：进程有一个独立的地址空间有自己的堆，
* 操作系统已进程为单位，进程是资源分配的最小单位

##### 线程
* 线程是进程的实体，是cpu调度的基本单位，比进程更小
* 与同属一个进程的线程共享全部的资源
* 相对于进程不够稳定，容易丢失数据

##### 协程
* 协程是一种用户态的轻量级线程
* 操作协程的时候是没有内核切换的开销，不用消耗资源，不用枷锁的访问上下文资源


##### 进程和线程比较
* 地址空间：进程包含线程，共享地址空间，进程有独立的地址空间
* 资源：进程是资源分配和拥有的单位，同一个进程中的线程共享进程的资源
* 线程是处理器（cpu）调度的基本单位，但进程不是。

##### 携程和线程比较
* 一个线程可以有多个协程，一个进程也可以单独拥有多个协程
* 线程进程都是同步的，协程是异步的
* 协程能保留上一次调用时的状态

#### redis的数据类型和特点
##### 数据类型
* string 字符串
* hash 哈希
* list 列表
* set 集合
* zet 有序集合
* Hyperloglog
* pub/sub
* redis module

##### 特点
* 速度快、持久化
* 支持丰富的数据类型
* 支持事务
* 丰富的特性
* 缓存、消息、key过期时间

#### redis的持久化机制是什么？

##### RDB（Redis DataBase）
* 只有一个文件dump.rdb，
* 容灾性好，
* 性能最大化，
* 效率更高
* 数据安全性低
##### AOF（append-only file）
* 数据安全
* 解决数据一致性的问题
* rewrite模式
* AOF 必RDB文件大 恢复速度慢， 数据集大的时候比rdb启动效率低


#### Redis保存热点数据解析
* redis内存数据集大小上升到一定的时候，就会施行数据淘汰策略
##### volatile-lru 设置了过期时间的数据 挑选最近最少使用的数据淘汰
##### volatile-ttl 设置过期时间的数据 挑选将要过期的数据淘汰
##### volatile-random 设置过期时间的数据集中任意随机选择数据淘汰
##### allkeys-lru 从数据集中挑选最近最少使用的数据淘汰
##### allkeys-random 从数据集中任意数据淘汰
##### no-enviction 禁止驱逐数据

#### 假如Redis里面有一亿个key，其中有10w个key是以某个固定的已知的前缀开头的，如何将它们全部找出来？
* 使用key指定可以扫除指定模式的key列表 (key XXX*)。 会阻塞
* scan指定，无阻塞的查看，可能会有重复，通过程序过滤重复的键


#### 使用过Redis做异步队列么，你是怎么用的？

* 一般使用list结构作为队列，rpush生产消息，lpop消费消息，当lpop没有消息时，适当使用sleep。

##### 可不可以不用sleep？
* 使用blpop,没有消息的时候会阻塞，直到消息的到来。


##### 一次生产多次消费
* pub/sub 订阅者模式，可以实现1:n（1对多）的消息队列

##### pub/sub订阅者模式的缺点
* 消费者下线的情况下，生产的消息会丢失

##### redis如何实现延时队列
* 使用sortedset 拿时间戳作为score，key调用zadd来生产消息，消费者用zrangebyscore指令来获取之前的数据进行轮训处理

* redisManger
```
class RedisManger
{
    private $redis;
    private $config = [
        'host' => '127.0.0.1',
        'port' => 6379
    ];
    public function __construct($redisConfig = [])
    {
        $redis = new Redis();
        $config = array_merge($this->config, $redisConfig);
        $redis->connect($config['host'], $config['port']);
        $this->redis = $redis;
    }
    public function zAdd($key, $score, $value)
    {
        $this->redis->zAdd($key, $score, $value);
    }
    public function zGet($key, $max)
    {
        return $this->redis->zRangeByScore($key, 0, $max);
    }
    public function zRemove($key)
    {
        return $this->redis->zRemRangeByRank($key, 0, 0);
    }
}
```
* 消费者
```
$redis = new RedisManger();
$key = 'test';
while (true) {
    $data = $redis->zGet($key, time());
    if ($data) {
        foreach ($data as $value) {
            # 执行逻辑
            echo $value . PHP_EOL;
            # 移除
            $redis->zRemove($key);
        }
    }
    sleep(1);
}
```
* 生产者
```
$redis = new RedisManger();
$time = time();
$redis->zAdd('test', time() + 50, "this is after 50 seconds");
$redis->zAdd('test', time() + 30, "this is after 30 seconds");
$redis->zAdd('test', time() + 40, "this is after 40 seconds");
```

#### Redis过期键的删除策略
* 定时删除（创建键的时候，同时创建一个定时器，当过期时间来临是执行键的删除操作）
* 惰性删除，（动态获取的时候去检查有没有过期）
* 定期删除，每个一段时间程序对数据库进行一次检查，检查过期键，至于要怎么删除，由算法决定。

#### 为什么redis 需要把所有数据放到内存中
* 为了最快的读写速度，然后将数据读到内存中

#### Redis 如何做内存优化？
* 散列表 （哈希hash）

#### Redis 回收进程如何工作的？



#### Redis 和 memcached的区别
* 1.redis 支持更多的数据结构
* 2.redis 可以持久化
* 3.key的字符长度限制不同
* 4.redis 单线程的模型，memcache 使用CAS保持并发数据一致性


#### 如何实现集群中的session共享存储
* 粘性session
* session 复制，session 变化，广播通知其他服务器变更
* session 共享，redis和memcache进行 session共享
* session 持久化，存储到数据库中，效率低。


#### 什么是rabbitmq？
* 采用了AMQP高级消息队列协议，
#### 为什么要使用rabbitmq?
* 在分布式系统下具备异步，肖峰，负载均衡等一系列高级功能
* 拥有持久化机制，进程消息队列中的信息也可以保存下来
* 实现了消费者和生产者之间的解耦
* 对于高并发场景下，采用消息队列可以使得同步访问变为串行访问，达到一定量的限流，利于数据库的操作
* 可以用消息队列达到异步下单的效果，排队中后台进行逻辑的下单。

#### Redis分布式锁应用场景及使用

##### 分布式锁的基本条件
* 互斥性，在仁义时刻，只有一个客户端能持有锁
* 不会发生死锁，及时有一个客户端在持有所得的期间崩溃而没有主动解锁，也能保证后续其他客户端能枷锁
* 洁玲还需系铃人，加锁和解锁必须是同一个客户端，客户端自己不能把别人加的锁个解了，不能误解锁

##### 什么是lua
* lua是一种轻量小巧的脚本语言，用标准c语言编写并以源代码形式开放，其设计目的是为了嵌入应用中，从而为应用程序提供灵活的扩展和定制功能