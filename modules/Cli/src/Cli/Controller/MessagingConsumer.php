<?php

namespace Cli\Controller;

use Zend\Mvc\Controller\ActionController;

class MessagingConsumer extends ActionController
{

  /**
   * Messaging Consume action.
   *
   * @return void
   */
  public function consumeAction()
  {
    return 'This is Messaging Consumer - Consumer action.';
  }
}
