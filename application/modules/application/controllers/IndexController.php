<?php

use Zend\Controller;
use Domain\Model;
use Zend\Registry,
    Domain\Model\User,
    Domain\Model\Invoice,
    Domain\Model\MoneyValue;

class IndexController extends \Zend\Controller\Action
{

  public function indexAction()
  {
    $dm = Registry::getInstance()->get('dm');
    
    $amount  = new MoneyValue(55, 'AUD'); 
    $invoice = new Invoice();
    $invoice->setTotal($amount);
    
    $dm->persist ( $invoice );
    $dm->flush();
    
    echo 'Invoice saved: '.$invoice->getId();
  }
  
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
