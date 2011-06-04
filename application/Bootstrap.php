<?php

use Zend\Config\Ini,
    Zend\Loader\StandardAutoloader,
    Zend\Registry,
    App\Application\Resource\DoctrineMongo,
    Domain\Model\User;

class Bootstrap extends \Zend\Application\Bootstrap
{
  
  /**
   * Autoloader.
   * 
   * TODO: Could not make it work in application.ini.
   * 
   * @return void.
   */
  protected function _initAutoloader()
  {
    $loader = new StandardAutoloader();
    $loader->registerNamespace('Doctrine', PROJECT_PATH.'/library/Doctrine')
           ->registerNamespace('App', PROJECT_PATH.'/library/App')
           ->registerNamespace('Domain', PROJECT_PATH.'/library/Domain');
    $loader->register();
  }
  
  /**
   * Init Mongo Document Manager. 
   * 
   * @return \Doctrine\ODM\MongoDB\DocumentManager
   */
  protected function _initMongo()
  {
    $config = new Ini(APPLICATION_PATH . '/configs/application.ini');
    
    $mongo = new DoctrineMongo($config);
    $dm    = $mongo->init();
    
    Registry::getInstance()->set('dm', $dm);
    
    return $dm;
  }
  
  protected function _initAuth()
  {
    $dm   = Registry::getInstance()->get('dm');
    $user = $dm->getRepository('Domain\Model\User')->find('4de999713eecad69a02e4145');
    
    // Simulate logged in User.
    Registry::getInstance()->set('user', $user);
  }
}
