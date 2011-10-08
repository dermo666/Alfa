<?php

namespace Invoice;

use Zend\Controller,
    Zend\Registry,
    Domain\Invoice\Repository\InvoiceRepository,
    Domain\Invoice\Entity\Invoice,
    Domain\Common\Entity\MoneyValue,
    Domain\User\Entity\User;

class IndexController extends \Zend\Controller\Action
{

  public function init()
  {
      /* Initialize action controller here */
  }

  public function indexAction()
  {
    // action body
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
    
    $repo = new InvoiceRepository($dm);
    $repo->add($invoice);
    
    $dm->flush();
    echo '<pre>Invoice created: ';print_r($invoice);
    
    $amount  = new MoneyValue(100, 'AUD'); 
    $invoice->setTotal($amount);

    $dm->flush();
    echo 'Invoice saved: ';print_r($invoice);
  }
}

