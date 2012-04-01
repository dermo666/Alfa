<?php

namespace Application;

use Zend\Module\Manager,
    Zend\EventManager\StaticEventManager,
    Zend\Module\Consumer\AutoloaderProvider;

class Module implements AutoloaderProvider
{
    protected $view;
    protected $viewListener;

    public function init(Manager $moduleManager)
    {
        $events = StaticEventManager::getInstance();
        $events->attach('bootstrap', 'bootstrap', array($this, 'initializeView'), 100);
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                		'App' 				=> __DIR__ . '/../../library/App',
                		'Domain'			=> __DIR__ . '/../../library/Domain',
                    'Doctrine'    => __DIR__ . '/../../vendors/Doctrine',
                    'Gedmo'       => __DIR__ . '/../../vendors/Doctrine/Extension/Gedmo',
                    'Doctrine\\ODM'    => __DIR__ . '/../../vendors/Doctrine/ODM',
                    'Doctrine\\DBAL'   => __DIR__ . '/vendors/Doctrine/DBAL',
                    'Doctrine\\Common' => __DIR__ . '/vendors/Doctrine/Common',
                    'Doctrine\\Common' => __DIR__ . '/vendor/Doctrine/Common',                    
                ),
            ),
        );
    }

    public function getConfig($env = null)
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function initializeView($e)
    {
        $app          = $e->getParam('application');
        $basePath     = $app->getRequest()->getBasePath();        
        $locator      = $app->getLocator();
        $renderer     = $locator->get('Zend\View\Renderer\PhpRenderer');
        $renderer->plugin('basePath')->setBasePath($basePath);       
    }
}
