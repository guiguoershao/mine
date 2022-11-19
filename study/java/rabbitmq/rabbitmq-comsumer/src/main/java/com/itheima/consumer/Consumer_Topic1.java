package com.itheima.consumer;

import com.rabbitmq.client.*;

import java.io.IOException;
import java.util.concurrent.TimeoutException;

public class Consumer_Topic1 {


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

        String queue1Name = "test_topic_queue1";

        //  6.接收消息
        /*
        String queue, 队列名称
        boolean autoAck, 是否自动确认，消费者消费消息，自动告诉mq 已收到消息
        Consumer callback  回调对象
         */

        Consumer consumer = new DefaultConsumer(channel) {
            /*
                回调方法，当收到消息后，会自动执行该方法
                String consumerTag, 消息标识
                Envelope envelope, 获取一些信息，交换机，路由key...
                AMQP.BasicProperties properties, 配置的信息
                byte[] body 真实的数据
             */
            @Override
            public void handleDelivery(String consumerTag, Envelope envelope, AMQP.BasicProperties properties, byte[] body) throws IOException {
//                super.handleDelivery(consumerTag, envelope, properties, body);
//                System.out.println("consumerTag: " + consumerTag);
//                System.out.println("envelope: Exchange:" + envelope.getExchange());
//                System.out.println("envelope: RoutingKey:" + envelope.getRoutingKey());
//                System.out.println("properties: " + properties);

                System.out.println("body: " + new String(body));
                System.out.println("将日志信息保存到数据....");
            }
        };

        channel.basicConsume(queue1Name, true, consumer);

        //  7.不用释放资源，一直监听消息
//        channel.close();
//        connection.close();
    }
}
