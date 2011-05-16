<?php

use Zend\Controller,
    Zend\Registry,
    Domain\Repository\InvoiceRepository,
    Domain\Model\Invoice,
    Domain\Model\MoneyValue,
    Domain\Model\User;

class IndexController extends \Zend\Controller\Action
{

  public function indexAction()
  {
    // TODO: View Variables to display them in the view.
    echo 'Hello World';
  }
  
  public function invoiceFindAction()
  {
    $dm = Registry::getInstance()->get('dm');
    
    $repo = new InvoiceRepository($dm);
    
    $invoices = $repo->findByTotal(55);
    
    echo 'Invoices found: '.count($invoices);
  }
  
  public function invoiceSaveAction()
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
