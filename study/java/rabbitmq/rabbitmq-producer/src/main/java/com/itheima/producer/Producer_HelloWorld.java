package com.itheima.producer;

import com.rabbitmq.client.Channel;
import com.rabbitmq.client.Connection;
import com.rabbitmq.client.ConnectionFactory;

import java.io.IOException;
import java.util.concurrent.TimeoutException;

/**
 * rabbitmq 发送消息
 * 第一种模式 简单模式
 */
public class Producer_HelloWorld {


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
        //  5.创建队列 Queue
        /*
        String queue,  队列名称
        boolean durable,  true 是否持久化，当mq重启之后，数据还存在，持久化到硬盘
        boolean exclusive, false 1.是否独占（只能有一个消费者监听这个队列） 2.当connection关闭时，是否删除队列
        boolean autoDelete, false 是否自动删除，当没有consumer时，自动删除掉。
        Map<String, Object> arguments  暂时设置为null
         */

        //  如果没有一个名字叫hello_world的队列，则会创建该队列，如果有则不会创建
        channel.queueDeclare("hello_world", true, false, false, null);
        //  6.发送消息
        /*
        String exchange,  交换机的名称。简单模式下交换机会使用默认 设置为空字符串""
        String routingKey,  路由名称 ,简单模式下 要和队列名称一样
        AMQP.BasicProperties props, 配置信息 null
        byte[] body 字节数组，真实放的消息数据
         */
        String body = "Hello rabbitmq, 你大爷";
        channel.basicPublish("", "hello_world", null, body.getBytes());

        //  7.释放资源
        channel.close();
        connection.close();
    }
}
