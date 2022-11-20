package com.itheima.producer;

import com.rabbitmq.client.BuiltinExchangeType;
import com.rabbitmq.client.Channel;
import com.rabbitmq.client.Connection;
import com.rabbitmq.client.ConnectionFactory;

import java.io.IOException;
import java.util.concurrent.TimeoutException;

/**
 * rabbitmq 发送消息
 * 第三种模式 Pub/Sub 订阅模式  一次向多个消费者发送消息
 * https://www.rabbitmq.com/getstarted.html
 */
public class Producer_Topic {


    public static void main(String[] args) throws IOException, TimeoutException {

        //  1.创建连接工厂
        ConnectionFactory factory = new ConnectionFactory();
        //  2.设置参数
        factory.setHost("120.77.156.30"); // ip连接地址 morning localhost
        factory.setPort(5672); // 端口 默认 5672
        factory.setVirtualHost("/itcast"); // 虚拟机 默认 /
        factory.setUsername("fengyan"); // 用户 默认 guest
        factory.setPassword("fengyan1992"); // 默认 guest
        //  3.创建连接 connection
        Connection connection = factory.newConnection();
        //  4.创建 Channel
        Channel channel = connection.createChannel();
        //  5.创建交换机
        /*
        String exchange, 交换机名称
        BuiltinExchangeType type, 交换机的类型，4种 【DIRECT("direct")： 定向, FANOUT("fanout") ： 广播（发送消息到每一个与之绑定的队列）, TOPIC("topic") ： 通配符的方式, HEADERS("headers") ： 参数匹配（使用较少）】
        boolean durable, 是否持久化
        boolean autoDelete,  是否自动删除
        boolean internal,   默认 false， mq内部使用。
        Map<String, Object> arguments 参数列表。 null
         */
        String exchangeName = "test_topic"; // 广播交换机
        channel.exchangeDeclare(exchangeName, BuiltinExchangeType.TOPIC, true, false, false, null);
        //  6.创建队列
        String queue1Name = "test_topic_queue1";
        String queue2Name = "test_topic_queue2";
        channel.queueDeclare(queue1Name, true, false, false, null);
        channel.queueDeclare(queue2Name, true, false, false, null);
        //  7.绑定队列和交换机
        /*
        String queue, 队列名称
        String exchange,  交换机名称
        String routingKey  路由键，绑定规则，如果交换机的类型为 fanout 广播 这个类型，那么该值设置为空字符串。
         */
        //  routing key 系统的名称，日志的级别
        //  需求：所有error级别的日志存入数据库，所有 order 系统的日志存入数据
        channel.queueBind(queue1Name, exchangeName, "#.error");
        channel.queueBind(queue1Name, exchangeName, "order.*");

        //  所有的日志信息都打印控制台
        channel.queueBind(queue2Name, exchangeName, "*.*");
        //  8.发送消息
        //  queue1Name queue2Name 都能收到
        String body = "订单:INFO:日志信息：张三调用了FindAll方法...日志级别为：info...";
        channel.basicPublish(exchangeName, "order.info", null, body.getBytes());

        //  queue2Name 能收到 queue1Name 收不到
        String body2 = "商品:INFO:日志信息：张三调用了FindAll方法...日志级别为：info...";
        channel.basicPublish(exchangeName, "goods.info", null, body2.getBytes());

        //  9.释放资源
        channel.close();
        connection.close();
    }
}