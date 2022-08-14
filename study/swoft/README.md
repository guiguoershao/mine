## 构建微服务
* getway (swoft) 端口: 8001, 
* user (swoft) 端口: 8002
* trade (swoft) 端口: 8003

### getway 
* 提供统一入口，让微服务对前台透明
* 聚合后台服务 
* 提供流量控制，过滤，日志收集，api管理

### RPC 
* 跨主机调用服务，它是一种通过网络从远程计算机程序上请求服务，而不需要了解底层网路技术的协议。
* 传输协议： 可以是自定义的tcp协议，http,websocket
* 编码协议：如基于文本编码的xml,json 也有二进制编码的protobuf,binpack等。

### 连接池
* 预先设定好一定的连接，如果连接不够会创建连接，会限制最大的连接数
* tcp连接、udp连接、mysql连接、redis连接
* 1.节省创建连接时间、资源，做连接复用
* 2.保护后台的服务（mysql）


### 服务限流


### 服务管理中心(注册中心),consul

#### 什么是服务发现
* 客户端应用进程向注册中心发起查询，来获取服务的位置。服务发现的一个重要作用就是提供一个可用的服务列表，微服务的框架体系中，必要存在的一个体系就是服务发现，对于服务进行管理，以及发现。
#### 什么是consul？
* consul 是一个支持多数据中心分布式高可用的服务发现和配置共享的服务软件
#### consul 提供以下关键特性
* service discovery：consul通过DNS或者HTTP接口使服务注册和服务发现变的很容易，一些外部服务。 
* health checking：健康检测使consul可以快速的警告在集群中的操作。和服务发现的集成，可以防止请求转发到故障的服务上面。
* key/value storage：一个用来存储动态配置的系统。提供简单的HTTP接口，可以在任何地方操作。

#### consul 安装
* 文档 https://www.mianshigee.com/tutorial/Swoft/zh-cn-service-governance-consul.md
* 官网 https://www.consul.io/downloads
* wget -O- https://apt.releases.hashicorp.com/gpg | gpg --dearmor | sudo tee /usr/share/keyrings/hashicorp-archive-keyring.gpg
* echo "deb [signed-by=/usr/share/keyrings/hashicorp-archive-keyring.gpg] https://apt.releases.hashicorp.com $(lsb_release -cs) main" | sudo tee /etc/apt/sources.list.d/hashicorp.list
* sudo apt update && sudo apt install consul

#### consul 的角色
##### server
* server 表示consul的server模式，表明这个consul是个server，这种模式下，功能和client都一样，唯一不同的是，它会把所有的信息持久化的本地，这样遇到故障，信息是可以被保留的。
* 持久化消息 
##### server-leader
* server 下面有leader的字眼，表明这个server是他们的老大，它和其他server不一样的一点是，它需要负责同步注册的信息给其他的server，同时也要负责各个节点的健康监测。
* 同步注册服务
* 健康检查
* 持久化信息

##### client
* consul的client模式，就是客户端模式。是consul节点的一种模式，这种模式下，所有注册到当前节点的服务会被转发到server，本身是不持久化这些信息。
* 只接受注册，并不会存储消息
* 注册服务，转发到服务端

#### 什么是服务注册？
* 某个服务在注册中心注册自己的位置。它通常注册自己的主机和端口号，有时还有身份验证信息，协议，版本号，以及运行环境的详细自立。服务注册简单的方式就是通过http请求取添加一个服务，携带json数据请求就可以做到。

##### 单机部署
```
# 创建启动命令
vim /data/consul/start_consul.sh
nohup /usr/bin/consul agent -server -ui -client 0.0.0.0 -bootstrap-expect=1 -data-dir=/data/consul/consul_data -config-dir=/data/consul/consul.d -node=consul-01 -advertise=120.77.156.30 -datacenter SH-TMP -bind=0.0.0.0 -log-file=/data/consul/consul_data/consul.log &

# agent -server 表示已 server 模式启动服务
# -ui 参数提供一个 web ui 界面
# -bootstrap-expect=1 意思是以集群的方式启动，只不过集群中只有当前这个节点
# -data-dir 目录会用来存放 consul 的数据信息，如服务注册、是否健康等
# -node=consul-01 节点名称 在一个集群中必须是唯一的，默认是该节点的主机名
* -bind 该地址用来在集群内部的通讯，集群内的所有节点到地址都必须是可达的，默认是0.0.0.0
# -advertise=120.77.156.30 改成自己的ip，或者去掉这个参数
* -rejoin 使consul忽略先前的离开，在再次启动后仍旧尝试加入集群中。
* client consul服务侦听地址，这个地址提供HTTP、DNS、RPC等服务，默认是127.0.0.1所以不对外提供服务，如果你要对外提供服务改成0.0.0.0
# -config-dir /data/consul/consul.d  加载置文件的目录，我们只需要填写配置文件的目录就可以帮助我们把该目录下所有的以.json结尾配置文件加载进去，它的加载顺序是根据26个字母的顺序加进行加载配置文件的。文件内容都是json格式的数据。默认后面文件定义配置会覆盖前面文件定义的配置。
# 对安全性没有要求的情况下其余都可以照抄

/data/consul/consul.d/basic.json 配置文件
{
    "ports": {  
        "http": 8011 , // 原端口 8500
        "dns": 8012, // 原端口 8600
        "grpc": 8013, // 原端口 8400
        "serf_lan": 8014, // 原端口 8301
        "serf_wan": 8015,  // 原端口 8302
        "server": 8016 // 原端口 8300
      }
}

chmod u+x /data/consul/start_consul.sh
/bin/sh /data/consul/start_consul.sh
```
##### Consul 集群搭建
* https://www.cnblogs.com/paul8339/p/16202015.html 参考文档

##### consul 服务注册

```
# Name 指定服务的逻辑名称，允许名称重复
# ID 指定服务的ID，此名称是唯一的
# Tags 指定要分配给服务的标签列表。这些标签可用于以后的过滤，并通过API公开
# Address 指定服务的地址
# Port 指定服务的端口
# 指定检查服务状态的相关参数指定。 HTTP 形式的请求、InterVal 检查时间
$server = [
    "ID" => "GetWay_001",  // 服务ID
    "Name" => "GetWay", // 服务名称
    "Tags" => [
        "primary", // 标签
    ],
    "Address" => "120.77.156.30", // 服务地址
    "Port" => 8001,
    "Check" => [
        "Http" => "http://120.77.156.30:8001/test/health",
        "Interval" => "5s",
    ]
];

注册地址：/agent/service/register json格式
```

#### 负载均衡
* 服务高可用的保证手段，为了保证高可用，每一个微服务都需要部署多个服务实例来提供服务。此时客户端进行的负载均衡。

##### 常见策略
* 随机：把来自网络的请求随机分配给内部中的多个服务器
* 轮训：每一个来自网络中的请求，轮流分配给内部的服务器，从1到N然后重新开始。此种负载均衡算法适合服务器组内部的服务器都具有相同的配置病情评价服务器请求相对均衡的情况。
* 加权轮询：根据服务器的不同处理能力，给每个服务器分配不同的权值，使其能够接受相应权值数的服务器请求。例如：服务器A的权值被设计成1，B的权值是3，C的权值是6，则服务器将分别接受到10%，30%，60%的服务器请求。此种均衡算法能够确保高性能的服务器得到更多的使用率，避免低性能的服务器负载过重。