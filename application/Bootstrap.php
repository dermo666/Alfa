<?php

use Gedmo;
use Zend\Loader;
use Zend\Config\Ini,
    Zend\Loader\StandardAutoloader,
    Zend\Registry,
    App\Application\Resource\DoctrineMongo,
    Domain\User\Entity\User;

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
           ->registerNamespace('Domain', PROJECT_PATH.'/library/Domain')
           ->registerNamespace('Gedmo', PROJECT_PATH.'/library/Doctrine/Extension/Gedmo');
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
  
  /**
   * Mimick the authenticated user.
   * 
   * @return void
   */
  protected function _initAuth()
  {
    $dm   = Registry::getInstance()->get('dm');
    $user = $dm->getRepository('Domain\User\Entity\User')->find('4de999713eecad69a02e4145');
    
    // Simulate logged in User.
    Registry::getInstance()->set('user', $user);
  }
  
  /**
   * Init View.
   * 
   * @TODO: Could not get this working - couldn't init the view helpers.
   * 
   * @return void
   */
  protected function _initView()
  {
    $this->bootstrap('layout');
    $this->_layout = $this->getResource('layout');
    $this->_view = $this->_layout->getView();
    
    $this->_view->plugin('doctype')->setDoctype('XHTML1_STRICT');
    $this->_view->plugin('headMeta')->appendHttpEquiv('Content-type', 'text/html;charset=utf-8');
    // TODO: $this->_view->plugin('headTitle')->setTitle('Project Alfa');?
    
//        $this->_view->addHelperPath('PPN/View/Helper','PPN_View_Helper');
//        $this->_view->addHelperPath('ZendX/JQuery/View/Helper','ZendX_JQuery_View_Helper');
//
//        $this->_view->jQuery()
//                        ->addStylesheet('/static/css/smoothness/jquery-ui-1.8.1.custom.css')
//                        ->setVersion('1.4.2')
//                        ->enable()
//                        ->setUiVersion('1.8.1')
//                        ->setLocalPath('/static/js/jquery-1.4.2.min.js')
//                        ->setUiLocalPath('/static/js/jquery-ui-1.8.1.custom.min.js')
//                        ->uiEnable();
//    $planetHelperLoader = new \Planet\View\HelperLoader();
//    $this->_view->plugin()->getClassLoader()->registerPlugins($planetHelperLoader);
  }
}
