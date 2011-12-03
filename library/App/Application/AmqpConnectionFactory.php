<?php

namespace App\Application;

use PhpAmqpLib\Connection\AMQPConnection;

class AmqpConnectionFactory
{

  /**
   * Configure and instantiate connection to Amqp Server.
   * 
   * @return 
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