<?php

namespace Cli\Controller;

use Zend\Mvc\Controller\ActionController;

class Cli extends ActionController
{

  public function indexAction()
  {
    echo 'This is Cli Index action.';
  }
}
