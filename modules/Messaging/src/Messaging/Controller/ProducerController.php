<?php

namespace Messaging\Controller;

use Zend\Mvc\Controller\ActionController,
    PhpAmqpLib\Connection\AMQPConnection,
    PhpAmqpLib\Message\AMQPMessage,
    PhpAmqpLib\Channel\AMQPChannel,
    App\Application\AmqpConnectionFactory;

class ProducerController extends ActionController
{

  const QUEUE_NAME    = 'test_queue';
  const EXCHANGE_NAME = 'router';
  
  /**
   * AMQP Connection.
   * 
   * @var   AMQPConnection
   */
  private $connection = NULL; 
  
  /**
   * Index Action.
   * 
   * @return void
   */
  public function indexAction()
  {
    $channel = $this->getAmqpChannel();
    
    $msg_body = 'This is message body';
    $msg      = new AMQPMessage($msg_body, array('content_type' => 'text/plain', 'delivery-mode' => 2));
    
    $channel->basic_publish($msg, self::EXCHANGE_NAME);
    
    $this->closeAmqpChannel($channel);

    return array(
            'message' => 'Message sent: '.$msg_body,
           );
  }
  
  /**
   * DI Setter injection for AMQP Connection.
   * 
   * @param AmqpConnectionFactory $amqpConnectionFactory Connection Factory.
   * 
   * @return ProducerController
   */
  public function setAmqpConnectionFactory(AmqpConnectionFactory $amqpConnectionFactory)
  {
    $this->connection = $amqpConnectionFactory->getAmqpConnection();
    return $this;
  }
  
  /**
   * Get connected AMQP Channel.
   * 
   * @return AMQPChannel
   */
  private function getAmqpChannel()
  {
    $channel = $this->connection->channel();

    /*
        name: $queue
        passive: false
        durable: true // the queue will survive server restarts
        exclusive: false // the queue can be accessed in other channels
        auto_delete: false //the queue won't be deleted once the channel is closed.
    */ 
    $channel->queue_declare(self::QUEUE_NAME, false, true, false, false);
    
    /*
        name: $exchange
        type: direct
        passive: false
        durable: true // the exchange will survive server restarts
        auto_delete: false //the exchange won't be deleted once the channel is closed.
    */    
    $channel->exchange_declare(self::EXCHANGE_NAME, 'direct', false, true, false);    

    $channel->queue_bind(self::QUEUE_NAME, self::EXCHANGE_NAME);
    return $channel;
  }
  
  /**
   * Close connection to AMQP Server.
   * 
   * @param AMQPChannel $channel AMQP Channel.
   * 
   * @return void
   */
  private function closeAmqpChannel(AMQPChannel $channel)
  {
    $channel->close();
    $this->connection->close();    
  }
}
