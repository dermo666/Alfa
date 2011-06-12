<?php

use Zend\Controller,
    Zend\Registry,
    Domain\Repository\InvoiceRepository,
    Domain\Model\Invoice,
    Domain\Model\MoneyValue,
    Domain\Model\User;

class IndexController extends \Zend\Controller\Action
{

  /**
   * Index Action.
   * 
   * @return void
   */
  public function indexAction()
  {
    $this->view->packages = array('Invoice', 'User');
  }
  
  /**
   * User action sample.
   * 
   * @TODO: Move this to User module.
   * 
   * @return void
   */
  public function saveUserAction()
  {
    $dm = Registry::getInstance()->get('dm');
    
    $user = new User ();
    $user->setName('Bulat S.');
    $user->setEmail('email@example.com');
    
    // tell Doctrine 2 to save $user on the next flush()
    $dm->persist ( $user );
  
    // store everything to MongoDB
    $dm->flush();
    
    echo 'User saved: '.$user->getId();
  }
}
