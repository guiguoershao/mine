package com.itheima;

import org.junit.Test;
import org.junit.runner.RunWith;
import org.springframework.amqp.rabbit.core.RabbitTemplate;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.test.context.ContextConfiguration;
import org.springframework.test.context.junit4.SpringJUnit4ClassRunner;

@RunWith(SpringJUnit4ClassRunner.class)
@ContextConfiguration(locations = "classpath:spring-rabbitmq-producer.xml")
public class ProducerTest {

    //1.注入 RabbitTemplate
    @Autowired
    private RabbitTemplate rabbitTemplate;

    @Test
    public void testHelloWorld() {
        //  2.发送消息 简单模式
        rabbitTemplate.convertAndSend("spring_queue", "你好，世界，你好 Spring！");
    }

    /**
     * 发送fanout消息 广播消息
     */
    @Test
    public void testFanout() {
        rabbitTemplate.convertAndSend("spring_fanout_exchange", "", "你好，世界，你好 Spring！这里是广播消息。");
    }

    /**
     * 发送Topic消息
     */
    @Test
    public void testTopics() {

        //  匹配到 spring_topic_queue_well 该队列
        rabbitTemplate.convertAndSend("spring_topic_exchange", "heima.one.two", "spring topic [heima.one.two:spring_topic_queue_well]");
    }
}
