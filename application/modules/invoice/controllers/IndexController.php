<?php

namespace Invoice;

use Domain\Invoice\Entity;

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
    
    $invoice = $invoices->getNext();
    echo '<pre>Invoice found: ';print_r($invoice);
  }
  
  public function invoiceCreateAndUpdateAction()
  {
    $dm = Registry::getInstance()->get('dm');
    
    $amount  = new MoneyValue(55, 'AUD'); 
    $invoice = new Invoice();
    $invoice->setTotalAmount($amount);
    
    $repo = new InvoiceRepository($dm);
    $repo->add($invoice);
    
    $dm->flush();
    echo '<pre>Invoice created: ';print_r($invoice);
    
    $amount  = new MoneyValue(100, 'AUD'); 
    $invoice->setTotalAmount($amount);

    $dm->flush();
    echo 'Invoice saved: ';print_r($invoice);
  }
  
  public function invoiceFindAndModifyAction()
  {
    $dm = Registry::getInstance()->get('dm');
    
    $repo = new InvoiceRepository($dm);
    
    $invoice = $repo->find('4eb4b9ff866a59eb04000000');
    
    echo '<pre>Invoice found: ';print_r($invoice);
    
    $amount  = new MoneyValue(200, 'AUD'); 
    $invoice->addAmount($amount);
    
    $dm->flush();
    echo '<pre>Invoice updated: ';print_r($invoice);
  }
}

