<?php

namespace Cli;

use Zend\Config\Config, Zend\Di\Configuration as DiConfiguration, Zend\Di\Di, Zend\EventManager\StaticEventManager;

class Bootstrap
{

  protected $config;

  public function __construct(Config $config)
  {
    $this->config = $config;
  }

  public function bootstrap(Application $app)
  {
    $this->setupLocatorFor( $app );
    $this->setupOptionsFor( $app );
  }

  protected function setupLocatorFor(Application $app)
  {
    /**
     * Instantiate and configure a DependencyInjector instance, or
     * a ServiceLocator, and return it.
     */
    $di = new Di ();
    $di->instanceManager ()->addTypePreference ( 'Zend\Di\Locator', $di );

    $config = new DiConfiguration ( $this->config->di );
    $config->configure ( $di );

    $app->setLocator ( $di );
  }

  protected function setupOptionsFor($app)
  {
    $options = $this->config->console_options->toArray ();
    $opts = new \Zend\Console\Getopt ( $options );

    $app->setOpts ( $opts );
  }
}