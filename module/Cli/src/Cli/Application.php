<?php

namespace Cli;

use ArrayObject,
    Zend\Mvc\AppContext,
    Zend\Di\Exception\ClassNotFoundException,
    Zend\Di\Locator,
    Zend\Tool\Framework\Client\Console\ResponseDecorator\Blockize,
    Zend\Console\Getopt;

/**
 * Main application class for invoking applications
 *
 * Expects the user will provide a Service Locator or Dependency Injector, as
 * well as a configured router. Once done, calling run() will invoke the
 * application, first routing, then dispatching the discovered controller. A
 * response will then be returned, which may then be sent to the caller.
 */
class Application /* implements AppContext */
{

  protected $locator;

  /**
   * Getopt.
   *
   * @var   Getopt;
   */
  protected $getopt;

  protected $router;

  /**
   * Set a service locator/DI object
   *
   * @param Locator $locator Locator.
   *
   * @return Application
   */
  public function setLocator(Locator $locator)
  {
    $this->locator = $locator;
    return $this;
  }

  /**
   * Getopt.
   *
   * @param Getopt $getopt Getopt.
   *
   * @return Application
   */
  public function setOpts(Getopt $getopt)
  {
    $this->opts = $getopt;
    return $this;
  }

  /**
   * Get the locator object
   *
   * @return null|Locator
   */
  public function getLocator()
  {
    return $this->locator;
  }

  /**
   * Get Getopt.
   *
   * @return Getopt.
   */
  public function getOpts()
  {
    return $this->opts;
  }

  public function run()
  {
    try {
      $getopt    = $this->getOpts ();
      $options   = $getopt->getOptions ();
      $arguments = $getopt->getRemainingArgs ();
    } catch ( \Zend\Console\Exception\RuntimeException $e ) {
      $this->showHelp($e->getMessage());
      exit();
    }

    if (count( $arguments ) == 0) {
      $this->showHelp('Missing action name.');
      exit();
    }

    $controllerName = array_shift ( $options );

    $actionName = $arguments [0];
    $actionName = \Zend\Mvc\Controller\ActionController::getMethodFromAction ( $actionName );

    $locator = $this->getLocator ();

    try {
      $controller = $locator->get ( $controllerName );
    } catch ( ClassNotFoundException $e ) {
      $this->showHelp ($e->getMessage());
      exit();
    }

    if ($controller instanceof LocatorAware) {
      $controller->setLocator ( $locator );
    }

    $response = null;

    if (method_exists ( $controller, $actionName )) {
      $response = $controller->$actionName ();
    } else {
      $this->showHelp ("Action $actionName does not exist.");
      exit();
    }

    echo $response . PHP_EOL;
  }

  protected function showHelp($msg)
  {
    $help = PHP_EOL . "Error: $msg" . PHP_EOL;

    $help .= "To run this CLI application, pass the name of the controller you want to invoke as ".
             "the first argument and the name of the action as the second argument.".PHP_EOL.
             "Example: --cli index for calling Controller Cli and Action Index.";

    $help .= PHP_EOL . $this->getOpts ()->getUsageMessage () . PHP_EOL;

    // TODO: Could not find this class anymore.
		//     $decorator = new Blockize ();
	
		//     $help = $decorator->decorate ( $help, 78 );

    echo $help . PHP_EOL;
  }
}
