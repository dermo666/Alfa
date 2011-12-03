<?php
/**
 * AMQP Connection Factory.
 *
 * TODO: Make this class open also channel in order to avoid code duplication - see Cli\MessagingConsumer
 *
 * @author tomas
 */

namespace App\Application;

use PhpAmqpLib\Connection\AMQPConnection;

class AmqpConnectionFactory
{

  /**
   * Configure and instantiate connection to Amqp Server.
   *
   * @return AMQPConnection
   */
  public function getAmqpConnection()
  {
    define('HOST', 'localhost');
    define('PORT', 5672);
    define('USER', 'guest');
    define('PASS', 'guest');
    define('VHOST', '/');

    return new AMQPConnection(HOST, PORT, USER, PASS, VHOST);
  }
}