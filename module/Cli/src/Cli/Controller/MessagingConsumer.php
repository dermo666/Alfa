<?php
/**
 * Cli Controller to demonstrate messaging feature - consuming of messages.
 *
 * @author tomas
 */

namespace Cli\Controller;

use Zend\Mvc\Controller\ActionController,
    PhpAmqpLib\Connection\AMQPConnection,
    PhpAmqpLib\Message\AMQPMessage,
    PhpAmqpLib\Channel\AMQPChannel,
    App\Application\AmqpConnectionFactory;

class MessagingConsumer extends ActionController
{

  const QUEUE_NAME    = 'test_queue';
  const EXCHANGE_NAME = 'router';
  const CONSUMER_TAG  = 'consumer';

  /**
   * AMQP Connection.
   *
   * @var   AMQPConnection
   */
  private $connection = NULL;

  /**
   * Messaging Consume action.
   *
   * @return void
   */
  public function consumeAction()
  {
    $channel = $this->getAmqpChannel ();

    $channel->basic_consume(self::QUEUE_NAME, self::CONSUMER_TAG, false, false, false, false, array($this, 'processMessage'));

    // Loop as long as the channel has callbacks registered
    while (count($channel->callbacks)) {
      $channel->wait();
    }

    $this->closeAmqpChannel ( $channel );

    return 'Script end.';
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
    $this->connection = $amqpConnectionFactory->getAmqpConnection ();
    return $this;
  }

  /**
   * Process Message.
   *
   * @param AMQPMessage $msg AMQP Message.
   *
   * @return void
   */
  public function processMessage(AMQPMessage $msg)
  {
    echo "\n--------\n";
    echo $msg->body;
    echo "\n--------\n";

    $msg->delivery_info ['channel']->basic_ack ( $msg->delivery_info ['delivery_tag'] );

    // Send a message with the string "quit" to cancel the consumer.
    if ($msg->body === 'quit') {
      $msg->delivery_info ['channel']->basic_cancel ( $msg->delivery_info ['consumer_tag'] );
    }
  }

  /**
   * Get connected AMQP Channel.
   *
   * @return AMQPChannel
   */
  private function getAmqpChannel()
  {
    // TODO: This is duplicated code from Messaging\ProducerController - make factory returning channel instead if connection.
    $channel = $this->connection->channel ();
    $channel->queue_declare ( self::QUEUE_NAME, false, true, false, false );
    $channel->exchange_declare ( self::EXCHANGE_NAME, 'direct', false, true, false );
    $channel->queue_bind ( self::QUEUE_NAME, self::EXCHANGE_NAME );
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
    $channel->close ();
    $this->connection->close ();
  }
}
