<?php
chdir(dirname(__DIR__));
require_once 'Zend/Loader/AutoloaderFactory.php';
Zend\Loader\AutoloaderFactory::factory();

$appConfig = include __DIR__ . '/../config/application.config.php';
$appConfig['modules'][] = 'Cli';

$listenerOptions  = new Zend\Module\Listener\ListenerOptions($appConfig['module_listener_options']);
$defaultListeners = new Zend\Module\Listener\DefaultListenerAggregate($listenerOptions);
$defaultListeners->getConfigListener()->addConfigGlobPath('config/autoload/*.config.php');

$moduleManager = new Zend\Module\Manager($appConfig['modules']);
$moduleManager->events()->attachAggregate($defaultListeners);
$moduleManager->loadModules();

$config = $defaultListeners->getConfigListener()->getMergedConfig();

// Create application, bootstrap, and run
$bootstrap   = new $config->cli_bootstrap_class($config);
$application = new Cli\Application;
$bootstrap->bootstrap($application);
$application->run();